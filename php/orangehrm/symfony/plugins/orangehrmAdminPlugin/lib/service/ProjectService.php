<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class ProjectService extends BaseService {

    private $projectDao;

    /**
     * Construct
     */
    public function __construct() {
        $this->projectDao = new ProjectDao();
    }

    /**
     *
     * @return <type>
     */
    public function getProjectDao() {
        return $this->projectDao;
    }

    /**
     *
     * @param UbCoursesDao $UbCoursesDao
     */
    public function setProjectDao(ProjectDao $projectDao) {
        $this->projectDao = $projectDao;
    }

    /**
     *
     * @param type $noOfRecords
     * @param type $offset
     * @param type $sortField
     * @param type $sortOrder
     * @return type 
     */
    public function getProjectList($noOfRecords, $offset, $sortField, $sortOrder) {
        return $this->projectDao->getProjectList($noOfRecords, $offset, $sortField, $sortOrder);
    }

    public function getProjectCount() {
        return $this->projectDao->getProjectCount();
    }

    public function deleteProject($projectId) {
        return $this->projectDao->deleteProject($projectId);
    }
	
	public function deleteProjectActivity($activityId) {
		return $this->projectDao->deleteProjectActivity($activityId);
	}

    public function getProjectById($projectId) {
        return $this->projectDao->getProjectById($projectId);
    }

    public function getProjectActivity($projectId) {
        return $this->projectDao->getProjectActivity($projectId);
    }

    public function getProjectActivityById($activityId) {
        return $this->projectDao->getProjectActivityById($activityId);
    }

    public function getAllActiveProjects() {
        return $this->projectDao->getAllActiveProjects();
    }

    public function getActivityListByProjectId($projectId) {
        return $this->projectDao->getActivityListByProjectId($projectId);
    }
	
	public function hasActivityGotTimesheetItems($activityId) {
		return $this->projectDao->hasActivityGotTimesheetItems($activityId);
	}

    public function isProjectHasTimesheetItems($projectId) {
        return $this->projectDao->isProjectHasTimesheetItems($projectId);
    }

    /**
     * Set Project Data Access Object
     * @param ProjectDao() $ProjectDao
     * @return void
     */
    public function setTimesheetDao(ProjectDao $projectDao) {

        $this->projectDao = $projectDao;
    }

    /**
     * Gets project name given project id.
     * @param integer $projectId
     * @return string
     */
    public function getProjectName($projectId) {

        $project = $this->readProject($projectId);
        $projectName = $project->getCustomer()->getName() . " - " . $project->getName();

        return $projectName;
    }

    public function readProject($projectId) {
        return $this->projectDao->readProject($projectId);
    }

    /**
     * When ProjectAdmin[] is given, this method extracts project ids and give it as an array.
     * @param ProjectAdmin[] $projectAdmins
     * @return integer[]
     */
    public function extractProjectIdsFromProjectAdminRecords($projectAdmins) {

        $projectId = array();
        foreach ($projectAdmins as $projectAdmin) {
            $projectId[] = $projectAdmin->getProjectId();
        }

        return $projectId;
    }

    public function getActiveProjectList() {

        return $this->getProjectDao()->getActiveProjectList();
    }

    public function getActiveProjectListRelatedToProjectAdmin($empNo, $emptyIfNotAprojectAdmin = false) {

        $projectAdmins = $this->getProjectDao()->getProjectAdminRecordsByEmpNo($empNo);

        $projectIdArray = array();

        if (!is_null($projectAdmins)) {
            foreach ($projectAdmins as $projectAdmin) {
                $projectIdArray[] = $projectAdmin->getProjectId();
            }
        }

        if (empty($projectIdArray)) {
            return array();
        }

        $projectList = $this->getProjectDao()->getActiveProjectsByProjectIds($projectIdArray);

        return $projectList;
    }

    /**
     *
     * @param int $empNumber 
     * @return array
     */
    public function isProjectAdmin($empNumber) {
        try {
            $projects = $this->getActiveProjectListRelatedToProjectAdmin($empNumber, true);
            return (count($projects) > 0);
        } catch (Exception $e) {
            // TODO: Warn
            return false;
        }
    }

    public function getProjectAdminList() {
        return $this->getProjectDao()->getProjectAdminList();
    }

    public function searchProjects($srchClues){
        return $this->getProjectDao()->searchProjects($srchClues);
    }

    public function getSearchProjectListCount($srchClues){
        return $this->getProjectDao()->getSearchProjectListCount($srchClues);
    }

}
