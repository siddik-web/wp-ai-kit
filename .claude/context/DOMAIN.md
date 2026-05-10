---
name: Domain Knowledge
description: Domain-specific business logic and concepts
---

# DOMAIN.md

Domain-specific knowledge about this project.

## Business Domain

This is a production-grade engineering starter. It's designed to be:
- Easily customizable for different domains
- WordPress/SaaS applicable
- AI-assisted development ready
- Long-term maintainable

## Core Concepts

- **Features grouped by functionality** — Not by file type
- **Layer isolation** — UI, application, and domain layers are separate
- **Business rules in domain layer** — Independent of transport/framework
- **Testable workflows** — Application layer orchestrates and validates

## Common Patterns

See [ARCHITECTURE.md](ARCHITECTURE.md) and [DECISIONS.md](DECISIONS.md) for:
- Layer boundaries
- Composition patterns
- Error handling approaches
- Validation strategy

## Anti-Patterns to Avoid

- ❌ Business logic in UI layer
- ❌ Direct DB access from UI
- ❌ Framework-specific code in domain layer
- ❌ Hidden side effects in functions
- ❌ Speculative abstractions

## Key Files to Know

- [CLAUDE.md](../../CLAUDE.md) — 25 engineering rules
- [ARCHITECTURE.md](ARCHITECTURE.md) — System layers and boundaries
- [CONVENTIONS.md](CONVENTIONS.md) — Naming, structure, style
- [DECISIONS.md](DECISIONS.md) — Why patterns exist

## Integration Points

- UI frameworks: (to be specified by implementation)
- Database: (to be specified by implementation)
- External APIs: (to be specified by implementation)
- Authentication: (to be specified by implementation)

## Migration & Compatibility

See [memory/migration-history.md](../memory/migration-history.md) for:
- Past breaking changes
- Migration guides
- Deprecated patterns

---

**Customize this file for your specific domain and business logic.**
