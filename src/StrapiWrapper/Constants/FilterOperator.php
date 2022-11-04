<?php

namespace Kazakevic\StrapiWrapper\Constants;

enum FilterOperator: string
{
    case EQ = '$eq';
    case EQI = '$eqi';
    case NE = '$ne';
    case LT = '$lt';
    case LTE = '$lte';
    case GT = '$gt';
    case GTE = '$gte';
    case IN = '$in';
    case NOT_IN = '$notIn';
    case CONTAINS = '$contains';
    case NOT_CONTAINS = '$notContains';
    case CONTAINSI = '$containsi';
    case NOT_CONTAINSI = '$notContainsi';
    case NULL = '$null';
    case NOT_NULL = '$notNull';
    case BETWEEN = '$between';
    case STARTS_WITH = '$startsWith';
    case ENDS_WITH = '$endsWith';
    case OR = '$or';
    case ANd = '$and';
}
