#!/bin/bash
git add .
git commit -m "Auto-commit: $(date '+%d-%m-%Y %H:%M:%S')"
git push origin main
