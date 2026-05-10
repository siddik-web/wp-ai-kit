---
name: explain
description: Explain code, architecture, patterns, or decisions
trigger: "/explain"
---

# Explain Command

Explains code, architectural patterns, design decisions, or system behavior.

## What It Does

1. **Code explanation**
   - Line-by-line walkthrough
   - Intent and purpose
   - Why this approach
   - Key decisions made

2. **Pattern explanation**
   - Why this pattern exists in codebase
   - When to use it
   - Alternatives considered
   - Edge cases

3. **Architecture explanation**
   - Component responsibilities
   - Data flow through system
   - Layer boundaries
   - Dependency direction

4. **Decision explanation**
   - Link to ADR if exists
   - Tradeoffs considered
   - Why this choice won
   - Alternatives rejected

5. **Error explanation**
   - What went wrong
   - Why it happened
   - How to fix it
   - How to prevent in future

## Output

- Clear, conversational explanation
- Diagrams or flowcharts if helpful
- Code examples
- Links to relevant documentation
- Alternative approaches if applicable

## Usage

```
@Claude /explain this function
@Claude /explain the checkout flow
@Claude /explain why we use composition here
@Claude /explain this error
@Claude /explain the authentication layer
```

## Documentation Sources

- [ARCHITECTURE.md](../../doc/ARCHITECTURE.md) — System design
- [DECISIONS.md](../../doc/DECISIONS.md) — ADRs and architectural decisions
- [CONVENTIONS.md](../../doc/CONVENTIONS.md) — Why patterns exist
- [CLAUDE.md](../../CLAUDE.md) — Engineering rules
- [memory/](../memory/) — Known issues and migration history
