<?php

namespace App\CRUD;

use EasyPanel\Contracts\CRUDComponent;
use EasyPanel\Parsers\Fields\Field;
use App\Models\Adoption;

class AdoptionComponent implements CRUDComponent
{
    // Manage actions in crud
    public $create = true;
    public $delete = true;
    public $update = true;

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    public $with_user_id = false;

    public function getModel()
    {
        return Adoption::class;
    }

    // which kind of data should be showed in list page
    public function fields()
    {
        return ['title', 'content', 'contact', 'image'];
    }

    // Searchable fields, if you dont want search feature, remove it
    public function searchable()
    {
        return ['title', 'content', 'contact', 'image'];
    }

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "checkbox", "text", "select", "file", "textarea"
    // "password", "number", "email", "select", "date", "datetime", "time"
    public function inputs()
    {
        return [
            'title'=> 'text',
            'content'=> 'text',
            'contact'=> 'text'
        ];
    }

    // Validation in update and create actions
    // It uses Laravel validation system
    public function validationRules()
    {
        return [
            'title'=> 'required|max:40',
            'content'=> 'required|max:255',
            'contact'=> 'required|max:40'
        ];
    }

    // Where files will store for inputs
    public function storePaths()
    {
        return [];
    }
}
