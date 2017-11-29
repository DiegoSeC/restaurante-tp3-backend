<?php

return array(
    'dsn' => 'https://3612cb53d4a944c7b16499cc43f5e7a9:1d57e72c2f4247f7a1ec6c4868003162@sentry.io/243269',

    // capture release as git sha
    // 'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    // Capture default user context
    'user_context' => true,
);