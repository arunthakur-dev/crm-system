#!/bin/bash /* sh auto-push.sh */

git add .
git commit -m "Auto-commit: $(date '+%d-%m-%Y %H:%M:%S')"
git push origin main
