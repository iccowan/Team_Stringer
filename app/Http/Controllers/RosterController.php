<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Mail;
use Carbon\Carbon;

class RosterController extends Controller
{
    public function showTeamRoster() {
        $team = Auth::user()->team_name;
        $team_token = Auth::user()->team_token;
        $coaches = User::where('role', 'COACH')->where('team_name', '=', $team)->where('team_token', $team_token)->get();
        $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
        $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();

        return view('coaches.roster.index')->with('coaches', $coaches)->with('players', $players)->with('stringers', $stringers);
    }

    public function newPlayer() {
        return view('coaches.roster.new');
    }

    public function saveNewPlayer(Request $request) {
        $validation = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users',
            'birthday' => 'required'
        ]);

        $date = $request->birthday;
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        $year = substr($date, 0, 4);
        $date = Carbon::create($year, $month, $day);
        $d = $date->toDateString();
        $now = Carbon::now()->subYears(13);
        $date_now = $now->toDateString();
        if($d >= $date_now) {
            return redirect()->back()->with('error', 'The user must be at least 13 years old to use Team Stringer. If they are older than 13, please check and make sure the date format for the birthday you entered is correct.');
        }

        $coach = Auth::user();
        $team = $coach->team_name;
        $team_token = $coach->team_token;
        $coaches = User::where('role', 'COACH')->where('team_name', $team)->where('team_token', $team_token)->get();
        $players = User::where('role', 'PLAYER')->orWhere('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
        $stringers = User::where('role', 'STRING')->where('team_name', $team)->where('team_token', $team_token)->get();
        if($coach->account_type == 0) {
            if($request->role == 0) {
                if($players->count() > 9) {
                    return redirect()->back()->with('error', 'You can only have 10 players on a free plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            } elseif($request->role == 1) {
                if($stringers->count() > 0) {
                    return redirect()->back()->with('error', 'You can only have 1 stringer on a free plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            } elseif($request->role == 2) {
                return redirect()->back()->with('error', 'You can only have 1 coach on a free plan. If you would like to add more, please view the profile page to upgrade your plan.');
            }
        } elseif($coach->account_type == 1) {
            if($request->role == 0) {
                if($players->count() > 14) {
                    return redirect()->back()->with('error', 'You can only have 15 players on a basic plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            } elseif($request->role == 1) {
                if($stringers->count() > 1) {
                    return redirect()->back()->with('error', 'You can only have 2 stringers on a basic plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            } elseif($request->role == 2) {
                if($coaches->count() > 1) {
                    return redirect()->back()->with('error', 'You can only have 2 coaches on a basic plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            }
        } elseif($coach->account_type == 2) {
            if($request->role == 0) {
                if($players->count() > 19) {
                    return redirect()->back()->with('error', 'You can only have 20 players on a high school plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            } elseif($request->role == 1) {
                if($stringers->count() > 3) {
                    return redirect()->back()->with('error', 'You can only have 4 stringers on a high school plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            } elseif($request->role == 2) {
                if($coaches->count() > 3) {
                    return redirect()->back()->with('error', 'You can only have 4 coaches on a high school plan. If you would like to add more, please view the profile page to upgrade your plan.');
                }
            }
        }

        $user = new User;
        $user->name = $request->fname.' '.$request->lname;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->password = 'NOT YET ACCEPTED INVITE';
        if($request->role == 0) {
            $user->role = 'PLAYER';
        } elseif($request->role == 1) {
            $user->role = 'STRING';
        } else {
            $user->role = 'COACH';
        }
        $user->account_type = 0;
        $user->team_name = $coach->team_name;
        $user->team_token = $coach->team_token;
        $user->save();

        Mail::send('emails.new_player', ['user' => $user, 'coach' => $coach], function ($m) use ($user, $coach) {
            $m->from('noreply@team-stringer.com', 'Team Stringer Invite');
            $m->to($user->email)->bcc($coach->email);
            $m->subject('Invitation from your coach to join Team Stringer');
        });

        return redirect('/coach/roster-manage')->with('success', 'The player or coach has been added successfully. An email has been sent to them with instructions on how to set a password.');
    }

    public function updatePlayer(Request $request, $id) {
        $coach = Auth::user();
        $stringers = User::where('role', 'STRING')->where('team_name', $coach->team_name)->where('team_token', $coach->team_token)->get();
        $player = User::find($id);
        if($request->option == 0) {
            if($coach->team_token == $player->team_token) {
                $player->delete();
                return redirect('/coach/roster-manage')->with('success', 'The player/coach has been removed successfully.');
            } else {
                return redirect()->back()->with('error', 'You can only delete players from a team that you are the coach of.');
            }
        } elseif($request->option == 1) {
            if($player->role == 'PLAYER') {
                if($coach->account_type == 0) {
                    if($stringers->count() > 0) {
                        return redirect()->back()->with('error', 'You can only have 1 stringer on a free plan. If you would like to add more, please view the profile page to upgrade your plan.');
                    }
                } elseif($coach->account_type == 1) {
                    if($stringers->count() > 1) {
                        return redirect()->back()->with('error', 'You can only have 2 stringers on a basic plan. If you would like to add more, please view the profile page to upgrade your plan.');
                    }
                } elseif($coach->account_type == 2) {
                    if($stringers->count() > 3) {
                        return redirect()->back()->with('error', 'You can only have 4 stringers on a high school plan. If you would like to add more, please view the profile page to upgrade your plan.');
                    }
                }

                if($coach->team_token == $player->team_token) {
                    $player->role = 'STRING';
                    $player->save();

                    return redirect('/coach/roster-manage')->with('success', 'The player has been updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'You can only edit players from a team that you are the coach of.');
                }
            } else {
                if($coach->team_token == $player->team_token) {
                    $player->role = 'PLAYER';
                    $player->save();

                    return redirect('/coach/roster-manage')->with('success', 'The player has been updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'You can only edit players from a team that you are the coach of.');
                }
            }
        }
    }
}
