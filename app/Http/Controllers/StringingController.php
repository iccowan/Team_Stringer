<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Racquet;
use App\StringRequest;
use Mail;

class StringingController extends Controller
{
    public function coachIndex(Request $request) {
        $coach = Auth::user();
        $team_token = $coach->team_token;
        $racquets_wait = StringRequest::where('team_token', $team_token)->where('status', 0)->orderBy('created_at')->paginate(20);
        $racquets_done = StringRequest::where('team_token', $team_token)->where('status', 1)->orderBy('created_at')->paginate(20);
        if($request->tab == 'done') {
            $page = $request->page;
            return view('coaches.stringing_index_done')->with('racquets_wait', $racquets_wait)->with('racquets_done', $racquets_done)->with('page', $page);
        } else {
            $page = $request->page;
            return view('coaches.stringing_index')->with('racquets_wait', $racquets_wait)->with('racquets_done', $racquets_done)->with('page', $page);
        }
    }

    public function completeRacquetRequest($id) {
        $updater = Auth::user();
        $request = StringRequest::find($id);
        if($updater->team_token == $request->team_token) {
            $request->status = 1;
            $request->updated_by = $updater->id;
            $request->save();
            $player = User::find($request->user_id);
            $racquet = Racquet::find($request->racquet_id);

            Mail::send('emails.racquet_finished', ['updater' => $updater, 'request' => $request, 'player' => $player, 'racquet' => $racquet], function ($m) use ($player, $request) {
                $m->from('noreply@team-stringer.com', 'Team Stringer Stringing Request Automated Email');
                $m->to($player->email);
                $m->subject('Racquet Stringing Request '.$request->id.' is Ready!');
            });

            return redirect('/coach/racquets-view')->with('success', 'The stringing request has been updated successfully and the player has been notified.');
        } else {
            return redirect()->back()->with('error', 'You can only update requests placed on your team.');
        }
    }

    public function deleteRacquetRequest($id) {
        $updater = Auth::user();
        $request = StringRequest::find($id);
        if($updater->team_token == $request->team_token) {
            $player = User::find($request->user_id);
            $racquet = Racquet::find($request->racquet_id);

            Mail::send('emails.racquet_deleted', ['updater' => $updater, 'request' => $request, 'player' => $player, 'racquet' => $racquet], function ($m) use ($player, $request) {
                $m->from('noreply@team-stringer.com', 'Team Stringer Stringing Request Automated Email');
                $m->to($player->email);
                $m->subject('Racquet Stringing Request '.$request->id.' has been Deleted');
            });

            $request->delete();
            return redirect('/coach/racquets-view')->with('success', 'The stringing request has been deleted successfully and the player has been notified.');
        } else {
            return redirect()->back()->with('error', 'You can only update requests placed on your team.');
        }
    }

    public function myRacquets() {
        $user = Auth::user();
        $racquets = Racquet::where('user_id', $user->id)->where('status', null)->get();
        return view('players.racquets')->with('racquets', $racquets);
    }

    public function newRacquet() {
        return view('players.new_racquet');
    }

    public function saveNewRacquet(Request $request) {
        $validation = $request->validate([
            'manu' => 'required',
            'type' => 'required',
            'string' => 'required',
            'tension' => 'required'
        ]);

        $user = Auth::user();
        $racquet = new Racquet;
        $racquet->user_id = $user->id;
        $racquet->team_token = $user->team_token;
        $racquet->manufacturer = $request->manu;
        $racquet->type = $request->type;
        $racquet->tension_lbs = $request->tension;
        $racquet->string = $request->string;
        $racquet->notes = $request->notes;
        $racquet->save();

        return redirect('/player/my-racquets')->with('success', 'The racquet has been added successfully.');
    }

    public function editRacquet($id) {
        $racquet = Racquet::find($id);
        if($racquet != null) {
            if($racquet->user_id == Auth::id()) {
                return view('players.edit_racquet')->with('racquet', $racquet);
            } else {
                return redirect()->back()->with('error', 'You can only make changes to your own racquets.');
            }
        } else {
            return redirect()->back()->with('error', 'That racquet does not exist.');
        }
    }

    public function deleteRacquet($id) {
        $racquet = Racquet::find($id);
        if($racquet != null) {
            if($racquet->user_id == Auth::id()) {
                $requests = StringRequest::where('racquet_id', $racquet->id)->get();
                $racquet->status = 0;
                return redirect('/player/my-racquets')->with('success', 'The racquet has been deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'You can only delete your own racquets.');
            }
        } else {
            return redirect()->back()->with('error', 'That racquet does not exist.');
        }
    }

    public function saveRacquet(Request $request, $id) {
        $validation = $request->validate([
            'manu' => 'required',
            'type' => 'required',
            'string' => 'required',
            'tension' => 'required'
        ]);

        $racquet = Racquet::find($id);
        if($racquet != null) {
            if($racquet->user_id == Auth::id()) {
                $racquet->manufacturer = $request->manu;
                $racquet->type = $request->type;
                $racquet->tension_lbs = $request->tension;
                $racquet->string = $request->string;
                $racquet->notes= $request->notes;
                $racquet->save();

                return redirect('/player/my-racquets')->with('success', 'The racquet has been edited successfully.');
            } else {
                return redirect()->back()->with('error', 'You can only edit your own racquets.');
            }
        } else {
            return redirect()->back()->with('error', 'That racquet does not exist.');
        }
    }

    public function viewStringRequests(Request $request) {
        $player = Auth::user();
        $racquets_wait = StringRequest::where('user_id', $player->id)->where('status', 0)->orderBy('created_at')->get();
        $racquets_done = StringRequest::where('user_id', $player->id)->where('status', 1)->orderBy('created_at')->paginate(20);
        $racquets = Racquet::where('user_id', $player->id)->get()->pluck('full_text', 'id');
        if($request->tab == 'done') {
            $page = $request->page;
            return view('players.stringing_requests_done')->with('racquets_wait', $racquets_wait)->with('racquets_done', $racquets_done)->with('racquets', $racquets)->with('page', $page);
        } else {
            return view('players.stringing_requests')->with('racquets_wait', $racquets_wait)->with('racquets_done', $racquets_done)->with('racquets', $racquets);
        }
    }

    public function searchTeamRequests(Request $request) {
        $request = StringRequest::find($request->search_params);
        if($request != null) {
            if($request->team_token == Auth::user()->team_token) {
                return view('stringers.request_details')->with('request', $request);
            } else {
                return redirect()->back()->with('error', 'You can only view details for racquets that belong to your team.');
            }
        } else {
            return redirect()->back()->with('error', 'A stringing request with that ID does not exist.');
        }
    }

    public function saveNewStringRequest(Request $request) {
        $validation = $request->validate([
            'racquet' => 'required'
        ]);

        $player = Auth::user();
        $racquet = Racquet::find($request->racquet);
        $string = new StringRequest;
        $string->user_id = $player->id;
        $string->team_token = $player->team_token;
        $string->racquet_id = $racquet->id;
        $string->status = 0;
        $string->save();

        return redirect()->back()->with('success', 'The stringing request has been created successfully! The ID for this request is '.$string->id.'. Please put this somewhere visible on the racquet as the person stringing this racquet will use this to lookup the information.');
    }

    public function deleteStringRequest($id) {
        $racquet = StringRequest::find($id);
        if($racquet != null) {
            if($racquet->user_id == Auth::id()) {
                $racquet->delete();
                return redirect('/player/my-string-requests')->with('success', 'The stringing request has been deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'You can only delete your own stringing requests.');
            }
        } else {
            return redirect()->back()->with('error', 'That stringing request does not exist.');
        }
    }

    public function viewTeamRequests(Request $request) {
        $stringer = Auth::user();
        $team_token = $stringer->team_token;
        $racquets = StringRequest::where('team_token', $team_token)->where('status', 0)->orderBy('created_at')->paginate(20);
        $page = $request->page;
        return view('stringers.view_requests')->with('racquets', $racquets)->with('page', $page);
    }

    public function viewTeamRequestDetails($id) {
        $request = StringRequest::find($id);
        if($request->team_token == Auth::user()->team_token) {
            return view('stringers.request_details')->with('request', $request);
        } else {
            return redirect()->back()->with('error', 'You can only view details for racquets that belong to your team.');
        }
    }

    public function completeRequest($id) {
        $updater = Auth::user();
        $request = StringRequest::find($id);
        if($updater->team_token == $request->team_token) {
            $request->status = 1;
            $request->updated_by = $updater->id;
            $request->save();
            $player = User::find($request->user_id);
            $racquet = Racquet::find($request->racquet_id);

            Mail::send('emails.racquet_finished', ['updater' => $updater, 'request' => $request, 'player' => $player, 'racquet' => $racquet], function ($m) use ($player, $request) {
                $m->from('noreply@team-stringer.com', 'Team Stringer Stringing Request Automated Email');
                $m->to($player->email);
                $m->subject('Racquet Stringing Request '.$request->id.' is Ready!');
            });

            return redirect('/stringer/team-string-requests')->with('success', 'The stringing request has been updated successfully and the player has been notified.');
        } else {
            return redirect()->back()->with('error', 'You can only update requests placed on your team.');
        }
    }
}
