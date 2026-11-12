# Wasmer GitHub deploy check

Small test apps for checking why first-time GitHub deploys on Wasmer fail more often than ZIP uploads
(77.2% vs 97.5% success within 7 days).

Each folder is one common kind of app. Deploy a folder from GitHub (set the root directory to the folder)
and upload the same folder as a ZIP, then compare the results.

| Folder | What it is | Expected |
| --- | --- | --- |
| `01-static-html` | One HTML file | Works |
| `02-php` | Plain PHP | Works |
| `03-php-composer` | PHP with a Composer dependency | Works |
| `04-node-server` | Node HTTP server, no build step | Works |
| `05-vite-build` | Vite site with a build step | Works |
| `06-python-flask` | Flask app | Works |
| `07-nextjs` | Minimal Next.js app | Works |
| `08-broken-build` | Vite site with a broken import | Fails on purpose, to see the error message |

The repo root itself is also a test: it has no app at the top level, like many real repos where the app
lives in a subfolder.
