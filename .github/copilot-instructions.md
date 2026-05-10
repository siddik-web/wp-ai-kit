# GitHub Copilot Instructions

This project is designed for AI-assisted development. See [AGENTS.md](../AGENTS.md) in the repository root for comprehensive agent instructions.

## Quick Reference

**Before coding**: Read [CLAUDE.md](../CLAUDE.md) — it contains 25 engineering rules that govern all work in this repository.

**Core principles**:
- Correctness over speed
- Simplicity over cleverness  
- Reuse before creating
- Surgical changes only
- Read before write
- Verify before claiming completion

**Key documentation** (in `doc/` folder):
- `ARCHITECTURE.md` — System design and layer boundaries
- `CONVENTIONS.md` — Naming, file structure, styling rules
- `TESTING.md` — Test requirements and philosophy
- `DECISIONS.md` — Why architectural patterns exist
- `SECURITY.md` — Security requirements
- `RELEASE.md` — Versioning and release process

**Success criteria**: Always verify:
- Tests pass
- Linting passes
- Type checks pass
- Security scans pass
- Changes are minimal (no unrelated reformatting)
- Backward compatibility preserved

See [AGENTS.md](../AGENTS.md) for workflows, common pitfalls, and token budget guidance.
