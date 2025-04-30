<?php

namespace App\Enums;

use App\Attributes\ClientPermission;
use App\Attributes\EmployeePermission;
use App\Attributes\FeaturePermission;
use App\Attributes\ManagerPermission;

enum PermissionsEnum: string
{
    /**
     * Permissions for paid features
     */
    #[FeaturePermission]
    case ADVANCED_REPORT    = "advanced-report";
    #[FeaturePermission]
    case ADVANCED_ANALYTICS = "advanced-analytics";


    /**
     * Permissions for standards access
     */
    // PRODUCTS PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_PRODUCTS         = "view-products";
    #[ManagerPermission]
    case CREATE_PRODUCTS       = "create-products";
    #[ManagerPermission]
    case EDIT_PRODUCTS         = "edit-products";
    #[ManagerPermission]
    case DELETE_PRODUCTS       = "delete-products";
    case FORCE_DELETE_PRODUCTS = "force-delete-products";

    // CATEGORIES PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_CATEGORIES         = "view-categories";
    #[ManagerPermission]
    case CREATE_CATEGORIES       = "create-categories";
    #[ManagerPermission]
    case EDIT_CATEGORIES         = "edit-categories";
    #[ManagerPermission]
    case DELETE_CATEGORIES       = "delete-categories";
    case FORCE_DELETE_CATEGORIES = "force-delete-categories";

    // SHOPS PERMISSIONS
    case VIEW_SHOPS         = "view-shops";
    case CREATE_SHOPS       = "create-shops";
    case EDIT_SHOPS         = "edit-shops";
    case DELETE_SHOPS       = "delete-shops";
    case FORCE_DELETE_SHOPS = "force-delete-shops";

    // EMPLOYEES PERMISSIONS
    #[ManagerPermission]
    case VIEW_EMPLOYEES         = "view-employees";
    #[ManagerPermission]
    case CREATE_EMPLOYEES       = "create-employees";
    #[ManagerPermission]
    case EDIT_EMPLOYEES         = "edit-employees";
    #[ManagerPermission]
    case DELETE_EMPLOYEES       = "delete-employees";
    case FORCE_DELETE_EMPLOYEES = "force-delete-employees";

    // VAT RATES PERMISSIONS
    case VIEW_VAT_RATES         = "view-vat-rates";
    case CREATE_VAT_RATES       = "create-vat-rates";
    case EDIT_VAT_RATES         = "edit-vat-rates";
    case DELETE_VAT_RATES       = "delete-vat-rates";
    case FORCE_DELETE_VAT_RATES = "force-delete-vat-rates";

    // USERS PERMISSIONS
    case VIEW_USERS         = "view-users";
    case CREATE_USERS       = "create-users";
    case EDIT_USERS         = "edit-users";
    case DELETE_USERS       = "delete-users";
    case FORCE_DELETE_USERS = "force-delete-users";

    // PRODUCT ATTRIBUTES PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_PRODUCT_ATTRIBUTES         = "view-product-attributes";
    #[ManagerPermission]
    case CREATE_PRODUCT_ATTRIBUTES       = "create-product-attributes";
    #[ManagerPermission]
    case EDIT_PRODUCT_ATTRIBUTES         = "edit-product-attributes";
    #[ManagerPermission]
    case DELETE_PRODUCT_ATTRIBUTES       = "delete-product-attributes";
    case FORCE_DELETE_PRODUCT_ATTRIBUTES = "force-delete-product-attributes";


    // SKUS PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_SKUS         = "view-skus";
    #[ManagerPermission]
    case CREATE_SKUS       = "create-skus";
    #[ManagerPermission]
    case EDIT_SKUS         = "edit-skus";
    #[ManagerPermission]
    case DELETE_SKUS       = "delete-skus";
    case FORCE_DELETE_SKUS = "force-delete-skus";


    // ATTRIBUTE SKUS PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_ATTRIBUTE_SKUS         = "view-attribute-skus";
    #[ManagerPermission]
    case CREATE_ATTRIBUTE_SKUS       = "create-attribute-skus";
    #[ManagerPermission]
    case EDIT_ATTRIBUTE_SKUS         = "edit-attribute-skus";
    #[ManagerPermission]
    case DELETE_ATTRIBUTE_SKUS       = "delete-attribute-skus";
    case FORCE_DELETE_ATTRIBUTE_SKUS = "force-delete-attribute-skus";


    // STOCK PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_STOCKS         = "view-stocks";
    case CREATE_STOCKS       = "create-stocks";
    #[ManagerPermission]
    case EDIT_STOCKS         = "edit-stocks";
    case DELETE_STOCKS       = "delete-stocks";
    case FORCE_DELETE_STOCKS = "force-delete-stocks";

    // STOCK MOVEMENT PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_STOCK_MOVEMENTS         = "view-stocks-movements";
    #[ManagerPermission]
    case CREATE_STOCK_MOVEMENTS       = "create-stocks-movements";
    #[ManagerPermission]
    case EDIT_STOCK_MOVEMENTS         = "edit-stocks-movements";
    #[ManagerPermission]
    case DELETE_STOCK_MOVEMENTS       = "delete-stocks-movements";
    case FORCE_DELETE_STOCK_MOVEMENTS = "force-delete-stocks-movements";

    // CLIENTS PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_CLIENTS         = "view-clients";
    #[ManagerPermission]
    case CREATE_CLIENTS       = "create-clients";
    #[ManagerPermission]
    case EDIT_CLIENTS         = "edit-clients";
    #[ManagerPermission]
    case DELETE_CLIENTS       = "delete-clients";
    case FORCE_DELETE_CLIENTS = "force-delete-clients";

    // LOYALTY OFFERS PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_LOYALTY_OFFERS         = "view-loyalty-offers";
    #[ManagerPermission]
    case CREATE_LOYALTY_OFFERS       = "create-loyalty-offers";
    #[ManagerPermission]
    case EDIT_LOYALTY_OFFERS         = "edit-loyalty-offers";
    #[ManagerPermission]
    case DELETE_LOYALTY_OFFERS       = "delete-loyalty-offers";
    case FORCE_DELETE_LOYALTY_OFFERS = "force-delete-loyalty-offers";

    // LOYALTY OFFERS PERMISSIONS
    #[ManagerPermission]
    #[EmployeePermission]
    case VIEW_SALES         = "view-sales";
    #[ManagerPermission]
    #[EmployeePermission]
    case CREATE_SALES       = "create-sales";
    #[ManagerPermission]
    case EDIT_SALES         = "edit-sales";
    #[ManagerPermission]
    case DELETE_SALES       = "delete-sales";
    case FORCE_DELETE_SALES = "force-delete-sales";

    public static function features(): array
    {
        $reflection = new \ReflectionEnum( self::class );
        $features   = [];

        foreach ($reflection->getCases() as $case) {
            if (!empty( $case->getAttributes( FeaturePermission::class ) )) {
                $features[] = $case->getValue();
            }
        }

        return $features;
    }

    public static function managers(): array
    {
        $reflection = new \ReflectionEnum( self::class );
        $features   = [];

        foreach ($reflection->getCases() as $case) {
            if (!empty( $case->getAttributes( ManagerPermission::class ) )) {
                $features[] = $case->getValue();
            }
        }

        return $features;
    }

    public static function employees(): array
    {
        $reflection = new \ReflectionEnum( self::class );
        $features   = [];

        foreach ($reflection->getCases() as $case) {
            if (!empty( $case->getAttributes( EmployeePermission::class ) )) {
                $features[] = $case->getValue();
            }
        }

        return $features;
    }

    public static function clients(): array
    {
        $reflection = new \ReflectionEnum( self::class );
        $features   = [];

        foreach ($reflection->getCases() as $case) {
            if (!empty( $case->getAttributes( ClientPermission::class ) )) {
                $features[] = $case->getValue();
            }
        }

        return $features;
    }
}
