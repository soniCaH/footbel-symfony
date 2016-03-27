set :application, "KevinVR Footbalisto App"
set :domain,      "qandisa.be"
set :user,        "sonicah"
set :deploy_to,   "/data/sites/sonicah/www/footbel"

set :deploy_via, :remote_cache

set :app_path,    "app"

set :repository,  "git@github.com:soniCaH/footbel-symfony.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :use_sudo,      false
set  :keep_releases,  5

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]

set :use_composer, true
set :update_vendors, true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

set :symfony_console, "bin/console"

after "deploy", "deploy:cleanup"
