<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function index() {

        $posts = Contact::where('user_id', Auth::user()->id)->get();
        
        return view('contacts', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        Contact::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'company' => $request->company,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return Redirect::to('/contacts');
    }

    public function update(Request $request)
    {
        $contact = Contact::findOrFail($request->id);
        $contact->update([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'company' => $request->company,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return Redirect::to('/contacts');
    }

    public function destroy(Request $request)
    {
        $contact = Contact::findOrFail($request->id);

        $contact->delete();

        return Redirect::to('/contacts');
    }

    public function search(Request $request)
    {
        $searchValue = $request->searchValue;

        $posts = Contact::where('user_id', Auth::user()->id)->where('name', 'LIKE', '%' . $searchValue . '%')->select('name', 'company', 'phone', 'email')->get();

        return response()->json($posts);
    }
}
