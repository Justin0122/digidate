<?php

namespace Justin0122\AuditingFrontend\Controllers;

use Illuminate\Routing\Controller;

class AuditTrailController extends Controller
{
    public function index()
    {
        return view('justin0122::audit-trail');
    }
}
