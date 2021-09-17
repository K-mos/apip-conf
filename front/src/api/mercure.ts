export const subscribe = (callback: Function): EventSource => {
  const url = new URL(`https://localhost/.well-known/mercure`);
  url.searchParams.append('topic', '*');

  const eventSource = new EventSource(url.toString());
  eventSource.onmessage = (e) => {
    const json = JSON.parse(e.data);
    callback(json);
  };

  return eventSource;
};
