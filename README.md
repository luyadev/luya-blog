<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA Blog

![Tests](https://github.com/luyadev/luya-blog/workflows/Tests/badge.svg)
[![Test Coverage](https://api.codeclimate.com/v1/badges/deb4edcd0aad00ca4bb1/test_coverage)](https://codeclimate.com/github/luyadev/luya-blog/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/deb4edcd0aad00ca4bb1/maintainability)](https://codeclimate.com/github/luyadev/luya-blog/maintainability)
[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

This package helps to create Blog behaviors with LUYA CMS.

## Installation

Install the extension through composer:

```sh
composer require luyadev/luya-blog
```

## Usage

The main idea behind LUYA Blog is to create a CMS Folder Structure which might be not rendered inside the application menu, but display in a "blog section" block. See the CMS Page illustration tree below:

```
.
├── About
├── Blog <= Add the BlogOverviewWidget here
│   ├── First Entry
│   ├── Second Entry
│   └── Last Entry
└── Homepage
```

+ [BlogOverviewWidget](https://github.com/luyadev/luya-blog/blob/master/src/widgets/BlogOverviewWidget.php): Use this widget to display all children pages for a given root page.