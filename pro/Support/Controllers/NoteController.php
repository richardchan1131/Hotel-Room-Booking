<?php

namespace Pro\Support\Controllers;

use Illuminate\Http\Request;
use Modules\FrontendController;
use Pro\Support\Models\UserNote;

class NoteController extends FrontendController
{

    public function delete($id)
    {
        if (!auth()->user()->hasPermission('support_ticket_reply') or !auth()->user()->hasPermission('support_ticket_manage')) {
            abort(403);
        }
        $a = UserNote::find($id);
        if ($a) $a->delete();

        return redirect()->back()->with('success', 'Note deleted');
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermission('support_ticket_reply') or !auth()->user()->hasPermission('support_ticket_manage')) {
            abort(403);
        }
        $request->validate([
            'content' => 'required'
        ]);
        $a = UserNote::find($id);
        if ($a) {
            $a->content = $request->input('content');
            $a->save();
        }

        return redirect()->back()->with('success', 'Note updated');
    }
}
