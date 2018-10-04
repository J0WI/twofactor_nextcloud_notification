<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) 2018, Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\TwoFactorNextcloudNotification\Controller;

use OCA\TwoFactorNextcloudNotification\Event\StateChanged;
use OCP\AppFramework\Controller;
use OCP\IConfig;
use OCP\IRequest;
use OCP\IUserSession;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SettingsController extends Controller {

	/** @var EventDispatcherInterface */
	private $dispatcher;

	/** @var IConfig */
	private $config;

	/** @var IUserSession */
	private $userSession;

	public function __construct(string $appName,
								IRequest $request,
								EventDispatcherInterface $dispatcher,
								IConfig $config,
								IUserSession $userSession) {
		parent::__construct($appName, $request);

		$this->dispatcher = $dispatcher;
		$this->config = $config;
		$this->userSession = $userSession;
	}

	public function enable() {
		$this->config->setAppValue($this->appName, $this->userSession->getUser()->getUID() . '_enabled', '1');
		$this->dispatcher->dispatch(StateChanged::class, new StateChanged($this->userSession->getUser(), true));
	}

	public function disable() {
		$this->config->setAppValue($this->appName, $this->userSession->getUser()->getUID() . '_enabled', '0');
		$this->dispatcher->dispatch(StateChanged::class, new StateChanged($this->userSession->getUser(), false));
	}
}
