<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\ContactService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed', Contact::WITH_TRASH),
        ];
        $contacts = $this->contactService->getAll($filters);

        if ($request->ajax()) {
            return response()->view('pages.contact.table_list_contact', compact('contacts','filters'));
        }

        return view('pages.contact.index', [
            'contacts' => $contacts,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return view('pages.contact.create');
    }

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();
        $validated['account_id'] = Auth::user()->account_id?Auth::user()->account_id:Auth::user()->id;
        $this->contactService->save($validated);
        
        return to_route('contacts.index')->with('success', __('common.contact.created'));
    }

    public function edit(Contact $contact, Request $request)
    {
        $filters = [
            'search'    => $request->input('q'),
            'trashed'   => $request->input('trashed', Contact::WITH_TRASH),
        ];
        return view('pages.contact.edit',[
            'contact'   => $contact,
            'filters'   => $filters,
        ]);
    }

    public function update(Contact $contact, UpdateContactRequest $request)
    {
        $validated = $request->validated();
        $contact->update($validated);
        return to_route('contacts.index')->with('success', __('common.contact.updated'));
    }

    public function destroy(Contact $contact)
    {
       if ($contact->del()) {
            return redirect()->route('contacts.index')->with('success', __('messages.contact.delete_success'));
        }
        return redirect()->route('contacts.index')->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Contact $contact)
    {
        $contact->restore();

        return redirect()->route('contacts.index')->with('success', __('messages.restore.success'));
    }   
    
    public function destroyPermanently(Contact $contact)
    {
        if ($contact->delP()) {
            return redirect()->route('contacts.index')->with('success', __('messages.permanent_delete.success'));
        }
        return redirect()->route('contacts.index')->with('error', __('messages.soft_delete.exception'));
    }   
}
