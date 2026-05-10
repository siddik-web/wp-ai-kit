---
name: refactor
description: Safely refactor code while preserving behavior and backward compatibility
trigger: "/refactor"
---

# Refactor Command

Performs safe, verified refactoring that preserves behavior and maintains backward compatibility.

## Refactoring Principles

1. **Read before write** (CLAUDE Rule 2)
   - Understand all callers
   - Identify usage patterns
   - Check for side effects

2. **Verify behavior preservation**
   - All tests pass before
   - All tests pass after
   - No behavior changes
   - No edge case changes

3. **Backward compatibility** (CLAUDE Rule 8)
   - Public APIs unchanged
   - Deprecation warnings if necessary
   - Migration path if breaking change required
   - Communicate impact clearly

4. **Minimal scope**
   - Single refactoring goal
   - Don't mix refactorings
   - Don't fix bugs during refactoring
   - Don't optimize during refactoring

## What It Does

1. **Refactoring analysis**
   - Identify improvement opportunity
   - Assess scope
   - List all affected callsites
   - Verify no hidden dependencies

2. **Safe refactoring**
   - Keep behavior identical
   - Update all callers
   - Add deprecation warnings if needed
   - Preserve error handling

3. **Testing**
   - All tests pass
   - Test coverage maintained
   - Behavior verified identical
   - Edge cases unchanged

4. **Verification**
   - No test failures
   - No performance regression
   - No type errors
   - Diffs are reviewable

## Output

- Refactoring goal and justification
- Files modified with explanations
- Verification results
- Impact assessment
- Migration guide (if breaking change)

## Usage

```
@Claude /refactor
@Claude /refactor extract-function
@Claude /refactor rename utils/helpers
@Claude /refactor consolidate-schemas
```

## Anti-Patterns (Don't Do)

- ❌ Mix refactoring with bug fixes
- ❌ Optimize during refactoring
- ❌ Break backward compatibility silently
- ❌ Skip tests during refactoring
- ❌ Reformat unrelated code
