Git deploy
==========

- does not loose a single request
- deploy locks, preventing multiple simultaneous deploys
- executes migrations and flushes cache

Installation
============

1. Setup git server http://git-scm.com/book/en/Git-on-the-Server-Setting-Up-the-Server
2. Put those files to newly created repos hooks
3. `chown git chmod ug+rwx,o=` those files
4. Change allowed branches in `Refs::validate`
5. Update `post-receive` `$deployPrefix` (real files prefix) and `$symlinkTarget` (symlink)
6. Update `post-receive` to restart your supervised worker etc
7. If you want deploy to push `deploy-*` tags to your github repo, setup github credentials to git user and add github remote to the bare repo.
