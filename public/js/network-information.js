function logConnectionInfo() {
  var properties = [
    'type',
    'effectiveType',
    'downlinkMax',
    'downlink',
    'rtt'
  ];

  console.log('Current Connection Status:');
  properties.forEach(function(property) {
    console.log('  ' + property + ':' +
      (navigator.connection[property] || '[unknown]'));
  });
}

if (navigator.connection) {

  navigator.connection.onchange = function() {
    logConnectionInfo();
    // location.reload();
  };

}


