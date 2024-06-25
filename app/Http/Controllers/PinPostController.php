<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PinPost;

class PinPostController extends Controller
{
    public function pin(int $post)
    {
        PinPost::create([
            'post_id' => $post
        ]);
    }

    public function unpin(int $post)
    {
        $pin = PinPost::where('post_id', $post);

        $pin->delete();
    }

    public function toggle(int $post)
    {
        $pin = PinPost::where('post_id', $post)->get();
        // dd($pin);

        if (count($pin) > 0) {
            $this->unpin($post);
        } else {
            $this->pin($post);
        }

        return redirect()->back();
    }

    public function getPinnedIDs(bool $onlyID = true)
    {
        $pinned = PinPost::all('post_id')->toArray() ?? [];
        $newPinned = [];

        if (!$onlyID) {
            return $pinned;
        }

        if (count($pinned) > 0) {
            foreach ($pinned as $pin) {
                foreach ($pin as $col => $value) {
                    $newPinned[] = $value;
                }
            }
        }
        
        return $newPinned;
    }
}
