<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only('member');
        $members = Member::filter($filters)->get();
        return view('members.index', compact('members'));
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $validated['member_code'] = random_alnum(6);

        $member = Member::create($validated);

        if ($member) {
            return back()->with('member_success', 'Member baru berhasil ditambahkan');
        }

        return back()->with('member_error', 'Member baru gagal ditambahkan');
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $updated = $member->update($validated);

        if ($updated) {
            return back()->with('member_success', 'Member berhasil diubah');
        }

        return back()->with('member_error', 'Member gagal diubah');
    }

    public function destroy(Member $member)
    {
        $deleted = $member->delete();

        if ($deleted) {
            return back()->with('member_success', 'Member berhasil dihapus');
        }

        return back()->with('member_error', 'Member gagal dihapus');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'member_code' => 'required|string',
        ]);

        $member = Member::where('member_code', $validated['member_code'])->first();



        if ($member) {
            $previousUrl = url()->previous() . '?member=' . $member->member_code;
            return redirect($previousUrl)->with('cart_success', "Member dengan kode '$member->member_code' ditemukan");
        }

        return back()->with('cart_error', "Member dengan kode '$request->member_code' gagal ditemukan");
    }
}
