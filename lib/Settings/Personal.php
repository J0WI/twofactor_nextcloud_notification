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

namespace OCA\TwoFactorNextcloudNotification\Settings;

use OCA\TwoFactorNextcloudNotification\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\Authentication\TwoFactorAuth\IPersonalProviderSettings;
use OCP\IConfig;
use OCP\IInitialStateService;
use OCP\Settings\ISettings;
use OCP\Template;

class Personal implements IPersonalProviderSettings {

	/** @var bool */
	private $enabled;
	/** @var IInitialStateService */
	private $initialStateService;

	public function __construct(IInitialStateService $initialStateService, bool $enabled) {
		$this->enabled = $enabled;
		$this->initialStateService = $initialStateService;
	}

	public function getBody(): Template {
		$this->initialStateService->provideInitialState(Application::APP_ID, 'state', $this->enabled);
		return new Template(Application::APP_ID, 'personal');
	}
}
