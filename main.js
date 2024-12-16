const { app, BrowserWindow } = require('electron');

let mainWindow;

app.on('ready', () => {
  // Create the main browser window
  mainWindow = new BrowserWindow({
    width: 1024,
    height: 768,
    webPreferences: {
      contextIsolation: true,
      enableRemoteModule: false,
    },
  });

  // Load the PHP project
  const phpProjectURL = 'http://localhost/beta/index.php'; // Replace with your project URL
  mainWindow.loadURL(phpProjectURL);

  // Prevent new windows from being created
  mainWindow.webContents.setWindowOpenHandler(() => {
    return { action: 'deny' };
  });

  // Ensure navigation happens in the same frame
  mainWindow.webContents.on('will-navigate', (event, url) => {
    console.log(`Navigating to: ${url}`);
  });

  // Handle window close
  mainWindow.on('closed', () => {
    mainWindow = null;
  });
});

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

app.on('activate', () => {
  if (mainWindow === null) {
    createWindow();
  }
});
