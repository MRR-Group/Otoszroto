<?php

declare(strict_types=1);

namespace App\Enums;

enum Permission: string
{
    case CreateAuction = "createAuction";
    case BanUsers = "banUsers";
    case ViewUsers = "viewUsers";
    case DeleteAuctions = "deleteAuctions";
    case ManageReports = "manageReports";
    case RenameUsers = "renameUsers";
    case ChangeUsersAvatar = "changeUsersAvatar";
    case AnonymizeUsers = "anonymizeUsers";
    case ManageAdministrators = "manageAdministrators";
    case ManageModerators = "manageModerators";
    case ViewLogs = "viewLogs";
}
