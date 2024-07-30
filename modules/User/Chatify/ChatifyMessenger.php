<?php

namespace Modules\User\Chatify;

class ChatifyMessenger extends \Chatify\ChatifyMessenger
{
    public function getUserAvatarUrl($user_avatar_name)
    {
        return $user_avatar_name;
    }

    /**
     * Get user with avatar (formatted).
     *
     * @param Collection $user
     * @return Collection
     */
    public function getUserWithAvatar($user)
    {
        if ($user->avatar == 'avatar.png' && config('chatify.gravatar.enabled')) {
            $imageSize = config('chatify.gravatar.image_size');
            $imageset = config('chatify.gravatar.imageset');
            $user->avatar = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?s=' . $imageSize . '&d=' . $imageset;
        } else {
            $user->avatar = static::getUserAvatarUrl($user->avatar_url);
        }
        return $user;
    }
}
