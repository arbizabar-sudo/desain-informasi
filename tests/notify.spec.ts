import { test, expect, request } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';

test('notification delivered across tabs via localStorage broadcast', async ({ browser }) => {
  // create sample data via debug endpoint
  const api = await request.newContext({ baseURL: BASE });
  const res = await api.get('/debug/create-sample');
  expect(res.ok()).toBeTruthy();
  const json = await res.json();
  const owner = json.owner;
  const actor = json.actor;
  const artwork = json.artwork;

  // shared context so localStorage events are shared across pages (simulates two tabs)
  const context = await browser.newContext();
  const ownerPage = await context.newPage();
  const actorPage = await context.newPage();

  // open owner page and ensure sidebar is ready
  await ownerPage.goto(`${BASE}/users/${owner.username}`);
  await ownerPage.waitForSelector('.notification-trigger');

  // set CURRENT_* globals on owner page to simulate logged-in owner
  await ownerPage.evaluate((o) => {
    window.CURRENT_USERNAME = o.username;
    window.CURRENT_USER_ID = o.id;
  }, owner);

  // open actor page and set actor globals
  await actorPage.goto(`${BASE}/users/${owner.username}`);
  await actorPage.waitForSelector('.thumbnail');
  await actorPage.evaluate((a) => {
    window.CURRENT_USERNAME = a.username;
    window.CURRENT_USER_ID = a.id;
  }, actor);

  // simulate broadcast from actor tab (like/save/share)
  const payload = {
    id: String(artwork.id),
    action: 'like',
    state: true,
    owner: owner.username,
    owner_username: owner.username,
    owner_id: owner.id,
    actor: actor.username,
    title: artwork.title,
    t: Date.now()
  };

  await actorPage.evaluate((p) => {
    localStorage.setItem('artwork-action', JSON.stringify(p));
    try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: p })); } catch(e) {}
    setTimeout(() => localStorage.removeItem('artwork-action'), 500);
  }, payload);

  // on owner page, wait for a notification to appear
  await ownerPage.waitForSelector('.notification-item', { timeout: 5000 });
  const notifText = await ownerPage.locator('.notification-item .notif-title').innerText();
  expect(notifText).toContain(actor.username);
  expect(notifText.toLowerCase()).toContain('liked');

  // cleanup
  await api.dispose();
  await context.close();
});
