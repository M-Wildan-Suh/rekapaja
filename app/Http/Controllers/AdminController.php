<?php

namespace App\Http\Controllers;

use App\Models\NoHandphone;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function premium() {
        $no_tlp = $this->getWhatsappNumber();
        return view('admin.premium.index', compact('no_tlp'));
    }

    private function getWhatsappNumber(): string
    {
        $no_tlp = NoHandphone::query()->value('no_tlp');

        if (!$no_tlp) {
            return '';
        }

        return preg_replace('/^0/', '+62', $no_tlp);
    }
}
