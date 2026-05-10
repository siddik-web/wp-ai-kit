# WORDPRESS.md

## Purpose

This project uses AI coding agents (Claude Code, Codex, Cursor, OpenAI Agents).

Agents must prioritize:
- correctness
- backward compatibility
- minimal diffs
- WordPress coding standards
- security
- performance
- maintainability

Do not optimize for novelty.
Optimize for safe production changes.

---

# Core Principles

## Think before coding

Before implementation:
- inspect related files
- inspect existing hooks/utilities/classes
- inspect callers and consumers
- identify conventions already in use

Never assume architecture.

If unclear:
- ask
- state assumptions explicitly
- stop guessing

---

## Simplicity first

Prefer:
- procedural code over premature abstractions
- existing WordPress APIs
- native WP hooks
- minimal dependencies

Avoid:
- unnecessary services
- speculative abstractions
- over-engineering
- framework-style patterns inside WP plugins

Smallest correct solution wins.

---

## Surgical changes only

Modify only what is required.

Do not:
- reformat unrelated code
- rename unrelated variables
- move files without need
- refactor unrelated systems

Keep diffs reviewable.

---

## Match existing conventions

Follow:
- existing architecture
- naming conventions
- folder structure
- hook naming patterns
- test style
- formatting

Conformance > preference.

---

# WordPress Standards

## Follow WordPress Coding Standards

Use:
- WordPress PHP Coding Standards
- escaping/sanitization standards
- nonce verification
- capability checks

Prefer:
- snake_case for functions
- PascalCase for classes
- kebab-case for handles/slugs

---

## Use WordPress APIs first

Prefer:
- wp_remote_get()
- wp_remote_post()
- WP_Query
- wp_enqueue_script()
- wp_enqueue_style()
- register_block_type()
- register_post_type()
- Settings API
- REST API
- Transients API
- Object Cache API

Avoid reinventing core functionality.

---

## Hooks

When adding hooks:
- prefix consistently
- document expected arguments
- preserve hook order compatibility

Never:
- rename public hooks
- silently remove hooks
- change hook signatures

Public hooks are API contracts.

---

## Database changes

Before schema changes:
- inspect upgrade paths
- inspect existing migrations
- preserve backward compatibility

Never:
- run destructive queries silently
- assume clean installs
- bypass dbDelta() without reason

All migrations must be idempotent.

---

## Gutenberg / Block Editor

Prefer:
- block.json metadata
- server-side rendering when appropriate
- native block supports
- Interactivity API where already used

Avoid:
- custom editor frameworks unless required
- duplicate block controls
- unnecessary client-side rendering

---

## WooCommerce

Use:
- WooCommerce CRUD APIs
- hooks/filters
- wc_get_* helpers

Avoid:
- direct postmeta manipulation when CRUD exists
- bypassing order/product abstractions

Preserve WooCommerce compatibility.

---

# Security Rules

## Treat all input as untrusted

Always:
- sanitize input
- validate data
- escape output contextually

Use:
- sanitize_text_field()
- absint()
- wp_unslash()
- esc_html()
- esc_attr()
- esc_url()

Use the correct escaping for the output context.

---

## Nonces and capabilities

Always verify:
- nonces
- current_user_can()

Never trust:
- AJAX requests
- REST requests
- admin requests
- client-side validation

---

## SQL Safety

Prefer:
- WP_Query
- metadata APIs
- taxonomy APIs

If SQL is required:
- use $wpdb->prepare()
- never interpolate variables directly

Never trust user-controlled SQL fragments.

---

# Performance Rules

## Performance is a feature

Prefer:
- lazy loading
- batched queries
- caching
- pagination
- indexed lookups

Avoid:
- N+1 queries
- loading all posts/options
- synchronous remote requests during page load

Measure before optimizing heavily.

---

## Frontend performance

Minimize:
- render-blocking assets
- frontend JS
- large dependencies

Prefer:
- native browser APIs
- server-rendered HTML
- conditional asset loading

Only enqueue assets where needed.

---

# Testing Rules

## Tests verify intent

Tests should explain:
- why behavior matters
- business rules
- regression prevention

Prefer:
- focused tests
- integration tests for WP hooks
- e2e tests for editor UX

Avoid brittle implementation-detail tests.

---

## Verify before completion

Before marking complete:
- run linting
- run tests
- verify activation
- verify fatal-free execution
- verify uninstall safety if touched

Do not claim success without verification.

---

# Agent Execution Rules

## Define success criteria first

Before implementation:
- define observable success
- define verification method
- define scope boundaries

Execution without success criteria is guessing.

---

## Fail loud

If:
- tests fail
- assumptions exist
- migration risk exists
- verification was skipped

state it explicitly.

Do not silently continue.

---

## Never invent project knowledge

Do not assume:
- plugin architecture
- package versions
- build systems
- available APIs
- environment variables
- deployment systems

Read source first.

---

## Reuse before creating

Before adding:
- utilities
- hooks
- components
- services
- helpers

search for existing implementations.

Extension > duplication.

---

# Recommended Workflow

1. Read related files
2. Identify conventions
3. Define success criteria
4. Implement minimal change
5. Run verification
6. Summarize:
   - what changed
   - what was verified
   - remaining risks
   - assumptions

---

# Preferred Tooling

## PHP
- PHPCS
- PHPStan
- Psalm (if already used)

## JavaScript
- ESLint
- TypeScript preferred for complex editor logic

## Testing
- PHPUnit
- Playwright
- WP-Env
- wp-env
- @wordpress/scripts

---

# Documentation Rules

Update docs when changing:
- public APIs
- hooks
- setup flow
- environment variables
- build commands
- block attributes
- REST endpoints

Keep examples accurate.

---

# Commit Discipline

One logical change per commit.

Avoid mixing:
- formatting
- refactors
- features
- migrations

Commits should explain intent clearly.

---

# Token Discipline

Prefer concise communication.

Summarize periodically during large tasks.

Do not consume context on:
- repeated explanations
- unnecessary output
- large generated boilerplate unless requested

---

# Definition of Done

Done means:
- requirements implemented
- verified working
- tests updated
- no known silent failures
- backward compatibility preserved
- security reviewed
- performance considered
- assumptions surfaced