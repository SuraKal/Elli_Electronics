<?php
    namespace App\Services;
    use App\Models\Tag;



    class TagService
    {
        public function getAllTags()
        {
            return Tag::all();
        }
        public function getTagsActive()
        {
            return Tag::query()->where('status', true);
        }

    }

