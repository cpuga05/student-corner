<?php

declare(strict_types=1);

namespace StudentCornerWeb\Controller\Notification;

use Shared\Infrastructure\Symfony\Controller;
use StudentCorner\Notification\Application\Show\ShowNotificationsQuery;
use StudentCorner\Notification\Domain\NotificationStatus;
use StudentCorner\Notification\NotificationsResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ListController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $userId = $request->attributes->get('user_id');
        /** @var NotificationsResponse $notifications */
        $notifications = $this->ask(
            new ShowNotificationsQuery(
                [
                    ['field' => 'userId', 'operator' => '=', 'value' => $userId],
//                    ['field' => 'status', 'operator' => '=', 'value' => NotificationStatus::UNREAD],
                ],
                'publishedAt',
                'desc',
                100,
                0
            )
        );

        return $this->render('nofifications/list.html.twig', ['notifications' => $notifications->notifications()]);
    }
}
