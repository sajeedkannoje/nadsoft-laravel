<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allMembers = Member::all();
        $treeStructurehtml = $this->getMembersList();
        return view('index', compact('treeStructurehtml', 'allMembers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $memberRequest) : JsonResponse
    {
        Member::create($memberRequest->validated());
        $treeStructurehtml = $this->getMembersList();
        return response()->json(['message' => 'Member added successfully',
                                  'data' => $treeStructurehtml], 200);
    }

    public function getMembersList()
    {
        $members = Member::with('subMembers')->whereNull('parent_id')->get();

        $memberListhtml = '<ul class="member-tree">';
        foreach ($members as $member) {
            $memberListhtml .= '<li>' . $member->name;
            if ($member->subMembers->count() > 0) {
                $memberListhtml .= $this->buildSubMembersHtml($member->subMembers);
            }
            $memberListhtml .= '</li>';
        }
        $memberListhtml .= '</ul>';

        return $memberListhtml;
    }

    private function buildSubMembersHtml($submembers)
    {
        $submemberListHtml = '<ul>';
        foreach ($submembers as $submember) {
            $submemberListHtml .= '<li>' . $submember->name;
            if ($submember->subMembers->count() > 0) {
                $submemberListHtml .= $this->buildSubMembersHtml($submember->subMembers);
            }
            $submemberListHtml .= '</li>';
        }
        $submemberListHtml .= '</ul>';

        return $submemberListHtml;
    }
}
