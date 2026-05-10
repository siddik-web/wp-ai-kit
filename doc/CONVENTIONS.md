# Engineering Conventions

## Naming

### Variables

Use descriptive names.

Avoid:
- data
- temp
- item
- thing

---

### Functions

Function names must describe behavior.

Examples:
- calculateInvoiceTotal
- validateCheckoutSession

Not:
- handleData
- processThing

---

## File Structure

Group by feature first.
Not by file type.

Prefer:

features/
  checkout/
    components/
    services/
    tests/

Over:

components/
services/
utils/

---

## Components

Components should:
- do one thing
- remain composable
- avoid hidden side effects

---

## Hooks/Utilities

Do not create abstractions for single use.

Extract only after duplication proves value.

---

## Comments

Comments explain:
- WHY
not:
- WHAT

Avoid redundant comments.

---

## Styling

Prefer:
- tokens
- reusable primitives
- consistent spacing scale

Avoid arbitrary values.

---

## Git

Commit messages:
- concise
- imperative
- scoped

Example:
feat(auth): add session expiration handling

---

## Logging

Logs must include:
- context
- identifiers
- actionable information

Never log secrets.