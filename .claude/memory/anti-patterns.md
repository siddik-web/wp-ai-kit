---
name: Anti-Patterns
description: Documented anti-patterns to avoid
---

# Anti-Patterns

Documented anti-patterns that have caused problems in this codebase. Avoid these patterns.

---

## Pattern 1: Business Logic in UI Components

**Problem**: Putting business rules, calculations, or data transformations in UI components makes them hard to test and reuse.

**Example** (DON'T):
```jsx
function CheckoutButton() {
  const handleClick = () => {
    // Business logic in component
    const total = items.reduce((sum, item) => sum + item.price, 0);
    const tax = total * 0.1;
    const discountApplied = user.isVIP ? total * 0.2 : 0;
    const finalTotal = total + tax - discountApplied;
    
    submit(finalTotal);
  };
  return <button onClick={handleClick}>Checkout</button>;
}
```

**Solution** (DO):
```jsx
// domain/checkout.ts
function calculateCheckoutTotal(items, user) {
  const subtotal = items.reduce((sum, item) => sum + item.price, 0);
  const tax = subtotal * 0.1;
  const discount = user.isVIP ? subtotal * 0.2 : 0;
  return subtotal + tax - discount;
}

// component
function CheckoutButton() {
  const handleClick = () => {
    const total = calculateCheckoutTotal(items, user);
    submit(total);
  };
  return <button onClick={handleClick}>Checkout</button>;
}
```

**Reference**: [ARCHITECTURE.md](../context/ARCHITECTURE.md) — UI Layer restrictions

---

## Pattern 2: Direct Database Access from Application Code

**Problem**: Multiple code paths accessing the database make it hard to change queries, optimize performance, or enforce consistency.

**Example** (DON'T):
```js
// Multiple places doing direct queries
const user = db.query("SELECT * FROM users WHERE id = ?", userId);
const posts = db.query("SELECT * FROM posts WHERE user_id = ?", userId);
```

**Solution** (DO):
```js
// Centralized data access layer
function getUserWithPosts(userId) {
  const user = db.query("SELECT * FROM users WHERE id = ?", userId);
  const posts = db.query("SELECT * FROM posts WHERE user_id = ?", userId);
  return { user, posts };
}

// All code uses the service
const { user, posts } = getUserWithPosts(userId);
```

**Reference**: [ARCHITECTURE.md](../context/ARCHITECTURE.md) — Layer separation

---

## Pattern 3: Silent Error Handling

**Problem**: Catching and ignoring errors makes bugs hard to diagnose. Errors should fail loud or provide actionable recovery.

**Example** (DON'T):
```js
try {
  await validateUser(token);
} catch (error) {
  // Silent failure - bug won't be noticed
}

// User silently not authenticated
continue();
```

**Solution** (DO):
```js
try {
  await validateUser(token);
} catch (error) {
  if (error.code === 'INVALID_TOKEN') {
    redirectToLogin();
  } else {
    logError('Token validation failed', error);
    throw error; // Re-throw if unexpected
  }
}
```

**Reference**: [CLAUDE.md Rule 13](../../CLAUDE.md#rule-13--make-failures-diagnosable)

---

## Pattern 4: Using String Concatenation for SQL

**Problem**: Concatenating SQL strings enables SQL injection vulnerabilities.

**Example** (DON'T):
```js
const query = `SELECT * FROM users WHERE email = '${email}'`;
const user = db.query(query);
```

**Solution** (DO):
```js
const user = db.query("SELECT * FROM users WHERE email = ?", [email]);
// or
const user = db.query("SELECT * FROM users WHERE email = $1", [email]);
```

**Reference**: [SECURITY.md](../context/SECURITY.md) — Input validation

---

## Pattern 5: Logging Secrets or Sensitive Data

**Problem**: Leaking secrets in logs exposes credentials and PII.

**Example** (DON'T):
```js
logger.info('User authenticated', { userId, token, apiKey });
logger.error('Payment failed', { card, cvv, reason });
```

**Solution** (DO):
```js
logger.info('User authenticated', { userId });
logger.error('Payment failed', { cardLast4: card.slice(-4), reason });
```

**Reference**: [CLAUDE.md Rule 9](../../CLAUDE.md#rule-9--security-before-convenience)

---

## Pattern 6: N+1 Queries

**Problem**: Fetching one item then looping and fetching related items causes excessive queries.

**Example** (DON'T):
```js
const users = db.query("SELECT * FROM users LIMIT 10");
for (const user of users) {
  // 10 additional queries!
  user.posts = db.query("SELECT * FROM posts WHERE user_id = ?", user.id);
}
```

**Solution** (DO):
```js
const users = db.query("SELECT * FROM users LIMIT 10");
const userIds = users.map(u => u.id);
const posts = db.query("SELECT * FROM posts WHERE user_id IN (?)", [userIds]);
// Merge results in application code
```

**Reference**: [CLAUDE.md Rule 10](../../CLAUDE.md#rule-10--performance-by-default)

---

## Pattern 7: Creating Abstractions for Single Use

**Problem**: Creating utility functions, hooks, or components before proving they're needed adds complexity without benefit.

**Example** (DON'T):
```js
// Created too early, only used once
const formatCurrencyHelper = (value) => `$${value.toFixed(2)}`;

function CheckoutTotal() {
  return <div>{formatCurrencyHelper(total)}</div>;
}
```

**Solution** (DO):
```js
// Inline until duplication proves value
function CheckoutTotal() {
  return <div>${total.toFixed(2)}</div>;
}

// Extract only after used in 3+ places
```

**Reference**: [CLAUDE.md Rule 4](../../CLAUDE.md#rule-4--simplicity-first)

---

## Pattern 8: Mixing Refactoring with Feature Work

**Problem**: Mixing refactoring with feature work creates large, hard-to-review diffs and increases risk.

**Example** (DON'T):
```
commit: "feat: add checkout feature and refactor auth system"
// Changes both new checkout code AND refactored authentication
```

**Solution** (DO):
```
commit 1: "refactor: consolidate auth utilities"
// Run tests, reviews, deploy, verify
commit 2: "feat: add checkout feature"
// Build on stable foundation
```

**Reference**: [CLAUDE.md Rule 5](../../CLAUDE.md#rule-5--surgical-changes)

---

## Pattern 9: Rewriting Working Code

**Problem**: Rewriting code that works just to match personal preference adds risk without benefit.

**Example** (DON'T):
```
// Code works, but I prefer a different style
// Rewrite just because
```

**Solution** (DO):
```
// Leave working code alone
// Fix or improve ONLY if:
// - Bug fix needed
// - Performance issue
// - Security issue
// - Duplication or reuse opportunity
```

**Reference**: [CLAUDE.md Rule 2](../../CLAUDE.md#rule-2--read-before-you-write)

---

## Pattern 10: Not Testing Error Paths

**Problem**: Tests only verify happy path, so error handling bugs go undetected.

**Example** (DON'T):
```js
test('loads user', async () => {
  const user = await loadUser(123);
  expect(user.name).toBe('Alice');
  // No test for when user doesn't exist
});
```

**Solution** (DO):
```js
test('loads user', async () => {
  const user = await loadUser(123);
  expect(user.name).toBe('Alice');
});

test('handles missing user', async () => {
  expect(async () => {
    await loadUser(999);
  }).rejects.toThrow('User not found');
});
```

**Reference**: [TESTING.md](../context/TESTING.md)

---

## Adding to This List

When you encounter an anti-pattern:
1. Document with clear name and description
2. Show example (don't-do and do versions)
3. Explain why it's problematic
4. Link to relevant documentation
5. Share with team to prevent recurrence
