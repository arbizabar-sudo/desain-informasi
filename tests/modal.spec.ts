import { test, expect, request } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';

test('opens artwork modal when thumbnail clicked', async ({ browser }) => {
  const api = await request.newContext({ baseURL: BASE });
  const res = await api.get('/debug/create-sample');
  expect(res.ok()).toBeTruthy();
  const json = await res.json();
  const owner = json.owner;

  const context = await browser.newContext();
  const page = await context.newPage();
  await page.goto(`${BASE}/users/${owner.username}`);
  await page.waitForSelector('.thumbnail');

  const thumb = page.locator('.thumbnail').first();
  const src = await thumb.getAttribute('src');
  await thumb.click();

  // frameModal should become visible and modal image src should match
  const modal = page.locator('#frameModal');
  await expect(modal).toBeVisible({ timeout: 3000 });
  const modalImgSrc = await page.locator('#modalImage').getAttribute('src');
  expect(modalImgSrc).toBe(src);

  await api.dispose();
  await context.close();
});