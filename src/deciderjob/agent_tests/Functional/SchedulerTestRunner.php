<?php
/*
Copyright (C) 2014, Siemens AG

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

namespace Fossology\DeciderJob\Test;

/**
 * @interface SchedulerTestRunner
 * @brief Interface for scheduler. Called by test case
 */
interface SchedulerTestRunner
{
  /**
   * @brief Setup and run agent based on inputs
   * @param int $uploadId
   * @param int $userId
   * @param int $groupId
   * @param int $jobId
   * @param string $args
   * @return array Run success code, agent output, agent return code
   */
  public function run($uploadId, $userId = 2, $groupId = 2, $jobId = 1, $args = "");
}
