import { test, expect, request } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';

test('explore page thumbnail opens modal and logs no JS errors', async ({ browser }) => {
  // ensure server has sample data
  const api = await request.newContext({ baseURL: BASE });
  const res = await api.get('/debug/create-sample');
  expect(res.ok()).toBeTruthy();
  const json = await res.json();

  const context = await browser.newContext();
  const page = await context.newPage();

  const consoleMessages: string[] = [];
  const pageErrors: string[] = [];

  page.on('console', msg => {
    consoleMessages.push(`${msg.type()}: ${msg.text()}`);
  });
  page.on('pageerror', err => {
    pageErrors.push(err.message || String(err));
  });

  await page.goto(`${BASE}/explore`);
  await page.waitForSelector('.thumbnail', { timeout: 5000 });

  const thumb = page.locator('.thumbnail').first();
  const src = await thumb.getAttribute('src');
  await thumb.click();

  // modal should open
  const modal = page.locator('#frameModal');
  await expect(modal).toBeVisible({ timeout: 3000 });
  const modalImgSrc = await page.locator('#modalImage').getAttribute('src');
  expect(modalImgSrc).toBe(src);

  // assert no page errors were captured
  if (pageErrors.length) {
    console.log('Page errors captured:', pageErrors);
  }
  expect(pageErrors.length).toBe(0);

  // helpful logs for debugging if something else appears
  console.log('Console messages:', consoleMessages.slice(-20));

  await api.dispose();
  await context.close();
});
