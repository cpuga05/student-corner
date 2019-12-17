<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller\User;

use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\Notification\Application\CounterNotificationsResponse;
use StudentCorner\Notification\Application\UnreadCounter\UnreadCounterNotificationsQuery;
use StudentCorner\Score\Application\ScoreResponse;
use StudentCorner\Score\Application\Show\ShowScoreQuery;
use StudentCorner\User\Application\UserResponse;
use StudentCorner\User\Application\View\ViewUserQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InfoBoxController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $userId = $request->attributes->get('user_id');
        /** @var UserResponse $user */
        $user = $this->ask(new ViewUserQuery($userId));
        /** @var ScoreResponse $score */
        $score = $this->ask(new ShowScoreQuery($userId));
        /** @var CounterNotificationsResponse $unreadNotificationsCounter */
        $unreadNotificationsCounter = $this->ask(new UnreadCounterNotificationsQuery($userId));

        return $this->render('users/info-box.html.twig', [
            'user_email' => $user->email(),
            'score' => $score->point(),
            'unread_notifications_counter' => $unreadNotificationsCounter->counter(),
        ]);
    }
}
