'use strict';

// Mirrors the isValidHexColor function in admin.js and sanitize_hex_color in PHP.
function isValidHexColor(value) {
  return /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(value);
}

describe('isValidHexColor', () => {
  test('accepts valid 6-digit hex', () => {
    expect(isValidHexColor('#d95459')).toBe(true);
    expect(isValidHexColor('#ffffff')).toBe(true);
    expect(isValidHexColor('#000000')).toBe(true);
  });

  test('accepts valid 3-digit hex', () => {
    expect(isValidHexColor('#fff')).toBe(true);
    expect(isValidHexColor('#abc')).toBe(true);
  });

  test('accepts mixed-case hex', () => {
    expect(isValidHexColor('#FF4F4F')).toBe(true);
    expect(isValidHexColor('#Ff4f4F')).toBe(true);
  });

  test('rejects value without leading hash', () => {
    expect(isValidHexColor('ffffff')).toBe(false);
    expect(isValidHexColor('fff')).toBe(false);
  });

  test('rejects empty string', () => {
    expect(isValidHexColor('')).toBe(false);
  });

  test('rejects invalid characters', () => {
    expect(isValidHexColor('#gggggg')).toBe(false);
    expect(isValidHexColor('#xyz')).toBe(false);
  });

  test('rejects wrong length', () => {
    expect(isValidHexColor('#ff')).toBe(false);
    expect(isValidHexColor('#fffffff')).toBe(false);
  });

  test('rejects 4- and 5-digit values (not valid CSS)', () => {
    expect(isValidHexColor('#1234')).toBe(false);
    expect(isValidHexColor('#12345')).toBe(false);
  });

  test('rejects CSS expressions and injection attempts', () => {
    expect(isValidHexColor('#fff; color: red')).toBe(false);
    expect(isValidHexColor('expression(alert(1))')).toBe(false);
    expect(isValidHexColor('')).toBe(false);
  });
});
