<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$page_title|default:'Sandstorm'}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f0f2f5; }
        .ss-navbar { background: #1a1a2e; }
        .ss-navbar .navbar-brand { font-weight: 700; font-size: 1.25rem; }

        /* Huisstijl: rood */
        :root { --ss-red: #c0392b; --ss-red-dark: #a93226; --bs-primary: #c0392b; --bs-primary-rgb: 192,57,43; }
        .btn-primary, .btn-primary:visited { background-color: var(--ss-red); border-color: var(--ss-red); color: #fff; }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: var(--ss-red-dark); border-color: var(--ss-red-dark); color: #fff; }
        .btn-outline-primary { color: var(--ss-red); border-color: var(--ss-red); }
        .btn-outline-primary:hover { background-color: var(--ss-red); border-color: var(--ss-red); color: #fff; }
        {block name="extra_css"}{/block}
    </style>
</head>
<body>

<nav class="navbar ss-navbar navbar-dark px-4 py-3 mb-5">
    <a class="navbar-brand" href="/"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Sandstorm</a>
    {if $auth_loggedin}
    <div class="d-flex align-items-center gap-3">
        <span class="text-white-50 small"><i class="bi bi-person-circle me-1"></i>{$auth_username|escape}</span>
        <a href="?action=logout" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right me-1"></i>Uitloggen</a>
    </div>
    {/if}
</nav>

<div class="container pb-5">
    {block name="content"}{/block}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{block name="extra_js"}{/block}
</body>
</html>
