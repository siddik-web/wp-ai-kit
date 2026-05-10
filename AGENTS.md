# AI Agent Instructions

This project is explicitly designed for AI-assisted development and autonomous coding agents. These instructions help agents be immediately productive.

## Project Purpose

**wp-ai-kit**: Production-grade engineering starter optimized for:
- AI-assisted development workflows
- Autonomous coding agents
- Scalable frontend/backend systems
- WordPress/SaaS applications
- Long-term maintainability

## Operating Philosophy

Before coding, understand these core principles ([see CLAUDE.md](CLAUDE.md) for details):

1. **Correctness over speed** — Verify assumptions before implementation
2. **Simplicity over cleverness** — Use the minimum code necessary
3. **Explicitness over assumptions** — Surface conflicts, name what's unclear
4. **Reuse before creating** — Check existing implementations first
5. **Surgical changes** — Modify only what's necessary
6. **Read before write** — Understand context before modifying code

**Critical rules agents must follow**:
- Never claim "done" without verification ([Rule 16](CLAUDE.md#rule-16--fail-loud))
- Preserve backward compatibility ([Rule 8](CLAUDE.md#rule-8--preserve-backward-compatibility))
- Security before convenience ([Rule 9](CLAUDE.md#rule-9--security-before-convenience))
- Match codebase conventions ([Rule 7](CLAUDE.md#rule-7--match-codebase-conventions))

## Essential Documentation

| Document | Purpose | When to Read |
|----------|---------|--------------|
| [CLAUDE.md](CLAUDE.md) | 25 comprehensive engineering rules | Before any implementation |
| [ARCHITECTURE.md](doc/ARCHITECTURE.md) | System layers and data flow | Understanding component boundaries |
| [CONVENTIONS.md](doc/CONVENTIONS.md) | Naming, file structure, styling | Writing new code or refactoring |
| [TESTING.md](doc/TESTING.md) | Testing philosophy and requirements | Before writing tests or claiming completeness |
| [DECISIONS.md](doc/DECISIONS.md) | Architectural decision records | Understanding why patterns exist |
| [SECURITY.md](doc/SECURITY.md) | Security requirements and practices | Any code handling sensitive data |
| [RELEASE.md](doc/RELEASE.md) | Release procedures and versioning | Before cutting releases |

## Common Agent Workflows

### Starting a Task

1. Read [CLAUDE.md](CLAUDE.md) sections relevant to the task
2. Identify success criteria and verification method ([Rule 6](CLAUDE.md#rule-6--define-success-before-execution))
3. State assumptions explicitly ([Rule 1](CLAUDE.md#rule-1--think-before-coding))
4. Search for existing implementations before creating ([Rule 3](CLAUDE.md#rule-3--reuse-before-creating))

### Implementing Features

1. Read [CONVENTIONS.md](doc/CONVENTIONS.md) for project naming and file structure
2. Check [ARCHITECTURE.md](doc/ARCHITECTURE.md) for layer boundaries
3. Follow surgical change principle — modify only what's necessary ([Rule 5](CLAUDE.md#rule-5--surgical-changes))
4. Match existing style; never reformat unrelated code
5. Verify via [TESTING.md](doc/TESTING.md) requirements

### Security & Validation

- All input is untrusted ([Rule 9](CLAUDE.md#rule-9--security-before-convenience))
- Validate input, sanitize data, escape output contextually
- Never interpolate raw SQL or expose credentials
- Review [SECURITY.md](doc/SECURITY.md) for application-specific requirements

### Handling Edge Cases

- If requirements are ambiguous: Present possible interpretations and ask ([Rule 1](CLAUDE.md#rule-1--think-before-coding))
- If structure seems unusual: Identify why before replacing patterns ([Rule 2](CLAUDE.md#rule-2--read-before-you-write))
- If dependency is needed: Verify necessity and evaluate maintenance quality ([Rule 23](CLAUDE.md#rule-23--explicit-dependency-discipline))

## Productivity Patterns

### Understanding the Codebase

- Features are grouped by functionality, not file type (see [CONVENTIONS.md](doc/CONVENTIONS.md#file-structure))
- Domain layer contains core business logic (independent of transport/UI)
- Application layer orchestrates workflows and validation
- UI layer handles rendering and accessibility only
- UI must NOT fetch from DB or contain business logic

### Code Quality Checks

Before claiming a task complete, verify:
- [ ] Tests pass (unit, integration, E2E as appropriate)
- [ ] Linting passes
- [ ] Type checking passes
- [ ] Security scans pass
- [ ] Backward compatibility preserved
- [ ] Documentation updated if non-trivial changes
- [ ] Changes are minimal and surgical (not reformatted unrelated code)

### Common Pitfalls to Avoid

- ❌ Claiming "done" without running tests
- ❌ Creating utility functions before proving duplication
- ❌ Breaking public APIs without migration guidance
- ❌ Logging secrets or sensitive data
- ❌ Rewriting code that works, just to match personal preference
- ❌ Creating speculative abstractions
- ❌ Skipping accessibility requirements
- ❌ Trusting client input without validation

## When to Stop and Ask for Clarification

- Requirements are contradictory or unclear
- Architecture feels wrong for the scope
- Existing pattern seems harmful ([Rule 15](CLAUDE.md#rule-15--surface-conflicts-explicitly))
- Task would require breaking changes but impact is unclear
- Multiple valid solutions exist with different tradeoffs

## Token Budget Awareness

- Per-task budget: 4k tokens target
- Per-session budget: 30k tokens target
- When approaching limits: Checkpoint progress and summarize state ([Rule 18](CLAUDE.md#rule-18--respect-token-budgets), [Rule 19](CLAUDE.md#rule-19--checkpoint-frequently))

---

**Key Principle**: This codebase is built for sustainable, maintainable engineering. Prefer boring and stable solutions. Production stability matters more than architectural novelty ([Rule 22](CLAUDE.md#rule-22--production-stability-over-perfection)).
