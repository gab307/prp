#!/bin/bash
find . -name cache -print0 | xargs -0 chmod -R 777;
find . -name logs -print0 | xargs -0 chmod -R 777;
find . -name tmp -print0 | xargs -0 chmod -R 777;
