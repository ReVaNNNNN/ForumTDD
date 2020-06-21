<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Channel $channel
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Channel $channel, int $id)
    {
        // dd($channel);
        $tread = Thread::find($id);

        $tread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
