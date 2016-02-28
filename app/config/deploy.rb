set :application, "decibels"
set :domain,      "decibels@web.mde.utc"
set :deploy_to,   "/sites/decibels"
set :app_path,    "app"

set :repository,  "git@github.com:Thewolfs/decibelsUTC.git"
set :scm,         :git
set :branch,      "master"
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

set  :use_sudo, false

set  :use_composer, true
set  :composer_bin,  "/sites/decibels/composer.phar"
set  :composer_options, "--verbose --working-dir=#{release_path} --optimize-autoloader "

set  :shared_children, [app_path + "/logs", web_path + "/uploads", "vendor"]
set  :shared_files, [app_path + "/config/custom.yml"]
# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL