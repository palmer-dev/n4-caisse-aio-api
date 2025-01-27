<?php

namespace App\enums;

enum PermissionsEnum: string
{
    // PRODUCTS PERMISSIONS
    case VIEW_PRODUCTS         = "view-products";
    case CREATE_PRODUCTS       = "create-products";
    case EDIT_PRODUCTS         = "edit-products";
    case DELETE_PRODUCTS       = "delete-products";
    case FORCE_DELETE_PRODUCTS = "force-delete-products";

    // CATEGORIES PERMISSIONS
    case VIEW_CATEGORIES         = "view-categories";
    case CREATE_CATEGORIES       = "create-categories";
    case EDIT_CATEGORIES         = "edit-categories";
    case DELETE_CATEGORIES       = "delete-categories";
    case FORCE_DELETE_CATEGORIES = "force-delete-categories";

    // CATEGORIES PERMISSIONS
    case VIEW_SHOPS         = "view-shops";
    case CREATE_SHOPS       = "create-shops";
    case EDIT_SHOPS         = "edit-shops";
    case DELETE_SHOPS       = "delete-shops";
    case FORCE_DELETE_SHOPS = "force-delete-shops";

    // CATEGORIES PERMISSIONS
    case VIEW_EMPLOYEES         = "view-employees";
    case CREATE_EMPLOYEES       = "create-employees";
    case EDIT_EMPLOYEES         = "edit-employees";
    case DELETE_EMPLOYEES       = "delete-employees";
    case FORCE_DELETE_EMPLOYEES = "force-delete-employees";
}
