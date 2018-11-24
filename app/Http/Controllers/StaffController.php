<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;
use Illuminate\Support\Facades\DB;
use Mail;
use Auth;
use GuzzleHttp\Client;

class StaffController extends Controller
{
    public function showCoachAccounts() {
        $coach = User::where('role', 'COACH')->get()->sortBy(function($c) {
            $lname = substr($c->name, strpos($c->name, " ") + 1);
            return $lname;
        });

        return view('staff.coaches')->with('coach', $coach);
    }

    public function showTeamDetails($id) {
        $coach = User::find($id);
        $players = User::where('team_token', $coach->team_token)->where('role', 'PLAYER')->orWhere('role','STRING')->get()->sortBy(function($p) {
            $lname = substr($p->name, strpos($p->name, " ") + 1);
            return $lname;
        });
        $stringers = User::where('team_token', '=', $coach->team_token)->where('role', 'STRING')->get()->sortBy(function($s) {
            $lname = substr($s->name, strpos($s->name, " ") + 1);
            return $lname;
        });

        return view('staff.team_details')->with('coach', $coach)->with('players', $players)->with('stringers', $stringers);
    }

    public function manageCoach(Request $request, $id) {
        $coach = User::find($id);
        if($coach->role == 'COACH'){
            if($request->option == 1) {
                $coach->account_type = $coach->account_type + 1;
                $coach->save();
            } elseif($request->option == 2) {
                $coach->account_type = $coach->account_type - 1;
                $coach->save();
            } elseif($request->option == 3) {
                $client = new Client;
                $response = $client->request('POST', 'https://api.sandbox.paypal.com/v1/payments/billing-agreements/'.$coach->plan_id.'/cancel', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '.env('SANDBOX_PAYPAL_TOKEN')
                    ],'body' =>
                        '{
                            "note": "Plan cancelled manually by staff member, '.Auth::user()->name.'."
                        }'
                ]);
            } elseif($request->option == 4) {
                $coach->delete();
                return redirect('/staff/coaches-account-manage')->with('success', 'Team removed successfully.');
            }
        } else {
            return redirect()->back()->with('error', 'This person is not a coach.');
        }

        return redirect()->back()->with('success', 'Team updated successfully.');
    }

    public function manageStaff() {
        $staff = User::where('role', 'STAFF')->get()->sortBy(function($c) {
            $lname = substr($c->name, strpos($c->name, " ") + 1);
            return $lname;
        });

        return view('staff.manage_staff')->with('staff', $staff);
    }

    public function newStaff() {
        return view('staff.new_staff');
    }

    public function saveNewStaff(Request $request) {
        $validation = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users',
            'birthday' => 'required'
        ]);

        $ian = User::find(3);

        $user = new User;
        $user->name = $request->fname.' '.$request->lname;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->password = 'NOT YET ACCEPTED INVITE';
        $user->role = 'STAFF';
        $user->account_type = 0;
        $user->team_name = $ian->team_name;
        $user->team_token = $ian->team_token;
        $user->save();

        Mail::send('emails.new_staff', ['user' => $user], function ($m) use ($user) {
            $m->from('noreply@team-stringer.com', 'Team Stringer Staff Invite');
            $m->to($user->email)->bcc('ian@team-stringer.com');
            $m->subject('Invitation to join the staff team at Team Stringer');
        });

        return redirect('/staff/staff-manage')->with('success', 'The staff member has been added successfully. An email has been sent to them with instructions on how to set a password.');
    }

    public function manageStaffMember(Request $request, $id) {
        if($id == 3) {
            return redirect()->back()->with('error', 'You cannot remove this staff member.');
        } else {
            $staff = User::find($id);
            $user = Auth::user();
            if($request->option == 0) {
                if($staff->role == 'STAFF') {
                    if($staff->password == 'NOT YET ACCEPTED INVITE') {
                        Mail::send('emails.delete_staff', ['staff' => $staff, 'user' => $user], function($m) use ($staff){
                            $m->from('noreply@team-stringer.com', 'Team Stringer Staff Removal');
                            $m->to($staff->email)->bcc('ian@team-stringer.com');
                            $m->subject('You have been removed from the staff team of Team Stringer');
                        });
                    }

                    $staff->delete();
                    return redirect()->back()->with('success', 'The staff member has been removed successfully.');
                } else {
                    return redirect()->back()->with('error', 'This person is not a staff member.');
                }
            } else {
                return redirect()->back()->with('error', 'You must select an option to continue.');
            }
        }
    }
}
