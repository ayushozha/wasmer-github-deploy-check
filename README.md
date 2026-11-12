# Wasmer GitHub deploy check

Small test apps for finding out why first-time GitHub deploys on Wasmer fail more often than ZIP uploads
(77.2% vs 97.5% success within 7 days).

Each folder is one common kind of app. Every folder was deployed on production twice: once from GitHub with the
root directory set to the folder, and once as a ZIP of the same folder. The `root-02-php` and
`root-03-php-composer` branches hold the two PHP apps at the repo root, to tell “GitHub” apart from “subfolder”.

## Results (production, Nov 12, 2026)

| Test | From GitHub | As a ZIP |
| --- | --- | --- |
| `01-static-html` | ✅ Works | ✅ Works |
| `02-php` in a subfolder | ❌ Deploy says success, site returns **403 Directory listing forbidden** | ✅ Works |
| `03-php-composer` in a subfolder | ❌ **Build fails**, no reason shown | ✅ Works |
| `02-php` at the repo root (branch `root-02-php`) | ✅ Works | — |
| `03-php-composer` at the repo root (branch `root-03-php-composer`) | ✅ Works | — |
| `04-node-server` | ✅ Works | ✅ Works |
| `05-vite-build` | ✅ Works | ✅ Works |
| `06-python-flask` | ✅ Works | ✅ Works |
| `07-nextjs` | ✅ Works | ✅ Works |
| `08-broken-build` (broken on purpose) | ❌ Fails, as expected | ❌ Fails, as expected |
| Repo root (app lives in subfolders) | ❌ Detected as Python, runs `python 06-python-flask/main.py`. Deploy says success, site returns **500** | ❌ Same |

“Works” means the deploy finished and the live URL returned the app with HTTP 200.

## What this shows

1. **GitHub itself works.** The same PHP apps deploy fine from GitHub when they sit at the repo root.
2. **PHP apps in a subfolder break on GitHub.** Plain PHP serves a 403 and PHP with Composer fails to build.
   Node, Vite, Python, Next.js and static sites in a subfolder all work.
3. **A repo whose app isn't at the top level gets the wrong framework.** Detection picks one file deep in the repo
   and runs it, and the result is a broken site.
4. **Two of the three failures report “success”.** The deploy status is green while the site returns 403 or 500,
   so these users don't show up as failures in our numbers.
5. **No failure reason is exposed.** The failed Composer build returns no reason through the API.

## How the test was run

- Detection: the `autobuildConfigForRepo` API call the dashboard uses, with `rootDir` set to each folder.
- Deploys: `deployViaAutobuild` from the GitHub repo (with `rootDir` or `branch`), and from a ZIP uploaded the way
  the dashboard does it. Each result was checked by requesting the live URL.
- Test apps were created in a personal namespace and expire after 3 days.
