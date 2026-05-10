---
name: wp-deploy
description: WordPress deployment workflows and environment management
trigger: "/wp-deploy"
---

# WordPress Deploy Command

Manages WordPress deployment workflows, environment configuration, and production releases.

## What It Does

1. **Environment Management**
   - Development/staging/production configs
   - Environment-specific settings
   - Database configuration
   - Asset optimization

2. **Deployment Automation**
   - Plugin/theme deployment
   - Database migrations
   - Asset compilation
   - Cache clearing

3. **WordPress-Specific Deployment**
   - WP-CLI integration
   - WordPress core updates
   - Plugin updates
   - Theme activation

4. **Rollback Procedures**
   - Safe rollback mechanisms
   - Version restoration
   - Database rollback
   - Cache invalidation

## Environment Configuration

### Environment Files
```
@Claude /wp-deploy config dev
```

Generates:
```
wp-config-dev.php
├── DB_NAME: 'myproject_dev'
├── DB_USER: from environment
├── DB_PASSWORD: from environment
├── WP_DEBUG: true
├── WP_DEBUG_LOG: true
├── SAVEQUERIES: true
└── DISALLOW_FILE_EDIT: false
```

### Production Config
```
@Claude /wp-deploy config prod
```

Generates hardened production configuration:
```
wp-config-prod.php
├── DB_NAME: from environment
├── DB_USER: from environment
├── DB_PASSWORD: from environment
├── WP_DEBUG: false
├── WP_DEBUG_LOG: false
├── SAVEQUERIES: false
├── DISALLOW_FILE_EDIT: true
├── FORCE_SSL_ADMIN: true
└── WP_MEMORY_LIMIT: '256M'
```

## Deployment Workflows

### Plugin Deployment
```
@Claude /wp-deploy plugin my-plugin --env=staging
```

Performs:
1. Code validation
2. Security audit
3. Build assets
4. Upload to staging
5. Activate plugin
6. Run tests
7. Clear caches

### Theme Deployment
```
@Claude /wp-deploy theme my-theme --env=production
```

Performs:
1. Theme validation
2. Accessibility audit
3. Asset optimization
4. Upload to production
5. Activate theme
6. Test critical pages
7. Performance monitoring

### Full Site Deployment
```
@Claude /wp-deploy site --env=production --backup=true
```

Performs:
1. Database backup
2. File system backup
3. Code deployment
4. Database migrations
5. Plugin updates
6. Cache clearing
7. Health checks
8. Rollback preparation

## WordPress CLI Integration

### Automated WP-CLI Commands
```bash
# Plugin management
wp plugin install my-plugin --activate
wp plugin update --all
wp plugin verify-checksums

# Theme management
wp theme install my-theme --activate
wp theme update --all

# Content management
wp core update
wp core verify-checksums
wp db optimize

# User management
wp user create admin admin@example.com --role=administrator
wp user update 1 --user_pass=$SECURE_PASSWORD
```

### Deployment Script Generation
```
@Claude /wp-deploy script plugin-deploy
```

Generates:
```bash
#!/bin/bash
# Plugin deployment script

# Configuration
PLUGIN_NAME="my-plugin"
PLUGIN_VERSION="1.0.0"
ENVIRONMENT="staging"

# Pre-deployment checks
wp core verify-checksums
wp plugin verify-checksums

# Backup
wp db export backup-pre-deploy.sql

# Deploy
wp plugin deactivate $PLUGIN_NAME
wp plugin delete $PLUGIN_NAME
wp plugin install $PLUGIN_NAME.zip --activate

# Post-deployment
wp cache flush
wp transient delete --all
wp rewrite flush

# Health check
wp plugin status $PLUGIN_NAME
wp option get my_plugin_version
```

## Hosting Platform Support

### WordPress.com VIP
```
@Claude /wp-deploy vip --env=production
```

Includes:
- VIP-specific code standards
- Enterprise security checks
- Performance optimizations
- VIP CLI integration

### WP Engine
```
@Claude /wp-deploy wpengine --env=staging
```

Includes:
- SFTP deployment
- Git push integration
- Environment-specific configs
- Cache management

### Kinsta
```
@Claude /wp-deploy kinsta --env=production
```

Includes:
- MyKinsta API integration
- Staging to production promotion
- CDN cache clearing
- Database optimization

## Security Hardening

### Production Hardening
```php
// Generated security configurations
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', false); // Allow plugin updates
define('WP_AUTO_UPDATE_CORE', true);
define('WP_AUTO_UPDATE_CORE', 'minor');
define('AUTOMATIC_UPDATER_DISABLED', false);
define('WP_HTTP_BLOCK_EXTERNAL', false);
define('WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,downloads.wordpress.org');
```

### File Permissions
```bash
# Secure file permissions
find /path/to/wordpress -type f -exec chmod 644 {} \;
find /path/to/wordpress -type d -exec chmod 755 {} \;
chmod 600 wp-config.php
chmod 600 .htaccess
```

## Monitoring & Health Checks

### Post-Deployment Verification
```bash
# Health checks
wp core check-update
wp plugin list --update=available
wp theme list --update=available
wp db check
wp cron test
```

### Performance Monitoring
```bash
# Performance checks
wp plugin activate query-monitor
wp plugin activate wp-rocket
wp cache flush
wp transient delete --all
```

## Rollback Procedures

### Plugin Rollback
```
@Claude /wp-deploy rollback plugin my-plugin --to-version=1.0.0
```

Performs:
1. Deactivate current version
2. Install previous version
3. Restore database if needed
4. Clear caches
5. Verify functionality

### Full Site Rollback
```
@Claude /wp-deploy rollback site --backup=backup-2024-01-15.sql
```

Performs:
1. Database restoration
2. Code reversion
3. Plugin reactivation
4. Cache clearing
5. Health verification

## Output

- Deployment scripts generated
- Configuration files created
- WP-CLI commands prepared
- Rollback procedures documented
- Monitoring setup instructions

## Usage

```
# Deploy plugin to staging
@Claude /wp-deploy plugin my-plugin --env=staging

# Deploy theme to production
@Claude /wp-deploy theme my-theme --env=production

# Full site deployment with backup
@Claude /wp-deploy site --env=production --backup=true

# Generate deployment script
@Claude /wp-deploy script full-deploy

# Rollback plugin
@Claude /wp-deploy rollback plugin my-plugin --to-version=1.0.0

# Setup environment config
@Claude /wp-deploy config prod
```

## Safety Features

- **Backup First**: Automatic backups before deployment
- **Staged Deployment**: Deploy to staging first
- **Health Checks**: Post-deployment verification
- **Rollback Ready**: Automatic rollback procedures
- **Dry Run Mode**: Test deployments without execution

## Integration

Works with:
- [RELEASE.md](../context/RELEASE.md) — Release procedures
- [WP-SECURITY.md](../context/WP-SECURITY.md) — Security hardening
- [WP-PERFORMANCE.md](../context/WP-PERFORMANCE.md) — Performance optimization
- Existing CI/CD workflows in `.github/workflows/`
