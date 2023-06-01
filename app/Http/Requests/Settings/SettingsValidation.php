<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingsValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'styleCSS' => 'nullable',
            'styleTheme' => 'in:corridor,red-haze,nodes,neon,flame,cosmos,hanipaganda,consultant,rainbow,null',
            'styleThemeShow' => 'in:0,1,2',

            'profileColor' => 'size:7',
            'character' => 'numeric',
            'profileAchievements' => 'boolean',
            'profileTalents' => 'boolean',
            'profileInventory' => 'boolean',
            'profileFriends' => 'boolean',

            'indexAnnouncements' => 'boolean',
            'indexWeb' => 'boolean',
            'indexUnity' => 'boolean',
            'indexOnline' => 'boolean',

            'navAuction' => 'boolean',
            'navGuides' => 'boolean',
            'navMap' => 'boolean',
            'navFaction' => 'boolean',
        ];
    }
}
