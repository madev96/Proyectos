<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //enviar el array de contactos
        $contacts = Contact::where('user_id',Auth::user()->id)->get();
        //enviar parametros al front con compact('contacts')
        return Inertia::render('Contact/Index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contact/Create');
    }
    public function store(StoreRequest $request)
    {
        $data = $request->except('avatar');
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $routeName = $file->store('avatars',['disk' => 'public']);
            $data['avatar'] = $routeName;
        }
        $data['user_id'] = Auth::user()->id;
        Contact::create($data);

        //para que nos muestre la tabla
        return to_route('contact.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return Inertia::render('Contact/Edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Contact $contact)
    {
        $data = $request->except('avatar');

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $routeName = $file->store('avatars',['disk' => 'public']);
            $data['avatar'] = $routeName;

        /*/para que se borre la imagen anterior si es acutalizada por otraa*/
        if($contact->avatar)   {
            Storage::disk('public')->delete($contact->avatar);
        }
        }

        $contact->update($data);

        return to_route('contact.edit',$contact);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if($contact->avatar)   {
            Storage::disk('public')->delete($contact->avatar);
        }

        $contact->delete();

        return to_route('contact.index');
    }
}
