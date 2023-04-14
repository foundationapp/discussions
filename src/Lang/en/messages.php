<?php

return [
    'words' => [
        'cancel'  => 'Cancel',
        'delete'  => 'Delete',
        'report'  => 'Report',
        'save'    => 'Save',
        'edit'    => 'Edit',
        'answer'  => 'Answer',
        'create'  => 'Create',
        'submit'  => 'Submit',
        'yes'     => 'Yes',
        'no'      => 'No',
        'minutes' => '1 minute| :count minutes',
    ],

    'discussion' => [
        'new'          => 'New ' . trans('discussions::intro.titles.discussion'),
        'all'          => 'All ' . trans('discussions::intro.titles.discussion'),
        'posted_by'    => 'Posted by',
        'head_details' => 'Posted in Category',
        'load_more'    => 'Load More',

    ],
    'response' => [
        'confirm'     => 'Are you sure you want to delete this response?',
        'yes_confirm' => 'Yes Delete It',
        'no_confirm'  => 'No Thanks',
        'submit'      => 'Submit response',
        'update'      => 'Update Response',
    ],

    'editor' => [
        'title'               => 'Title of ' . trans('discussions::intro.titles.discussion'),
        'content'             => 'Content of ' . trans('discussions::intro.titles.discussion'),
        'reply'               => 'Write a Reply',
        'select'              => 'Select a Category',
        'tinymce_placeholder' => 'Type Your ' . trans('discussions::intro.titles.discussion') . ' Here...',
        'select_color_text'   => 'Select a Color for this ' . trans('discussions::intro.titles.discussion') . ' (optional)',
    ],

    'email' => [
        'notify'       => 'Notify me when someone replies',
        'dont_notify' => 'Don\'t notify me when someone replies',
    ],

    'auth' => 'Please <a href="/:home/login">login</a>
                or <a href="/:home/register">register</a>
                to leave a response.',

];
