# {{name}}

Here is the repository of the [Laravel Nova {{name}} integration]({{link}})

### ⚠ Staging: This has not launched yet.

This is a proposed integration & basic foundation code.

Feel free to PR some contributions to expedite the process.

You can upvote to prioritize it & subscribe for notification:

{{link}}

### Pre-launch install:

To install directly from github before we add to packagist:

Add the following to your nova project's composer.json
```js
"require": {
    "{{owner}}/{{repository}}": "*"
},

"repositories": {
    {
        "type": "vcs",
        "url": "git@github.com:{{owner}}/{{repository}}.git"
    }
}
```