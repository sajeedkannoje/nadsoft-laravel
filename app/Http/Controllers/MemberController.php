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
        // Fetch the list of members and their submembers
        $members = Member::with('subMembers')->whereNull('parent_id')->get();

        // Construct the HTML structure
        $html = '<ul class="member-tree">';
        foreach ($members as $member) {
            $html .= '<li>' . $member->name;
            if ($member->subMembers->count() > 0) {
                $html .= $this->buildSubMembersHtml($member->subMembers);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';

        // Return the HTML as a response
        return $html;
    }

    private function buildSubMembersHtml($submembers)
    {
        $html = '<ul>';
        foreach ($submembers as $submember) {
            $html .= '<li>' . $submember->name;
            if ($submember->subMembers->count() > 0) {
                $html .= $this->buildSubMembersHtml($submember->subMembers);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
