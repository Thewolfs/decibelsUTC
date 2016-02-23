set :application, "decibels"
set :domain,      "files.mde.utc"
set :deploy_to,   "public_html"
set :app_path,    "app"

set :repository,  "git@github.com:Thewolfs/Decibels.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

set  :shared_files, ["app/config/parameters.yml"]
set  :shared_children, [app_path + "/logs", web_path + "/uploads", "vendors"]

set  :use_composer, true

set  :user, "decibels"

set  :use_sudo, false

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL