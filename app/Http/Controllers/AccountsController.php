<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    public function index()
    {
//        if (Auth::user()->can('Manage User')) {
            $accounts = Account::where('created_by', '=', Auth::user()->getCreatedBy())->get();

            return view('accounts.index')->with('accounts', $accounts);
//        } else {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }

    public function create()
    {
//        if (Auth::user()->can('Create User')) {
            return view('accounts.create');
//        } else {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }





    public function store(Request $request)
    {
        // dd($request->all());
//        if (Auth::user()->can('Create User')) {
            $validatorArray = [
                'type' => 'required',
                'name' => 'required|max:255',
                'ref' => 'nullable|max:255',
            ];

            $validator = Validator::make(
                $request->all(),
                $validatorArray
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            if (!empty(env('DEFAULT_LANG'))) {
                $default_language = env('DEFAULT_LANG');
            } else {
                $default_language = 'en';
            }

            $account['name']      = $request->input('name');
            $account['ref']     = $request->input('ref');
            $account['type']   = $request->input('type');
            $account['created_by']   = Auth::user()->id;

            $account = Account::create($account);

            return redirect()->route('accounts.index')->with('success', __('Accounts added successfully.'));

//        } else {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }



    public function show(Account $account)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Account $account)
    {
//        if (Auth::user()->can('Edit User')) {

            return view('accounts.edit', compact('account'));
//        } else {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }

    public function update(Request $request, Account $account)
    {
//        if (Auth::user()->can('Edit User')) {
            $validatorArray = [
                'type' => 'required',
                'name' => 'required|max:255',
                'ref' => 'nullable|max:255',
            ];

            $account->name     = $request->name;
            $account->ref    = $request->ref;
            $account->type  = $request->type;
            $account->updated_by = Auth::user()->id;

            $account->save();

            return redirect()->route('accounts.index')->with('success', __('Accounts updated successfully.'));
//        } else {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }

    public function destroy(Account $account)
    {
//        if (Auth::user()->can('Delete User')) {
            $account->delete();

            return redirect()->route('accounts.index')->with('success', __('Acconts successfully deleted.'));
//        } else {
//            return redirect()->back()->with('error', __('Permission denied.'));
//        }
    }
}
