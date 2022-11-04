<?php

namespace Kazakevic\StrapiWrapper\Constants;

enum StrapiFilter: string
{
    case POPULATE = 'populate';
    case LOCALE = 'locale';
    case FILTERS = 'filters[%s][%s]';
}
