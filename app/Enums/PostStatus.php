<?php

namespace App\Enums;

enum PostStatus: string {
    case PUBLIC = 'public';
    case FRIENDS = 'friends';
    case ME = 'me';
}