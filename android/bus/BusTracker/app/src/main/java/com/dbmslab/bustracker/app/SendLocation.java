package com.dbmslab.bustracker.app;

import android.app.Activity;
import android.app.Dialog;
import android.app.DialogFragment;
import android.content.Context;
import android.content.Intent;
import android.content.IntentSender;
import android.content.SharedPreferences;
import android.location.Location;
import android.location.Geocoder;
import android.location.Location;
import android.location.Address;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ShareActionProvider;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.ErrorDialogFragment;
import com.google.android.gms.common.GooglePlayServicesClient;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.location.LocationClient;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicHeader;
import org.apache.http.protocol.HTTP;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.PrintWriter;
import java.net.Socket;
import java.net.URI;
import java.util.List;
import java.util.Locale;
import java.util.Random;
import  java.lang.Object;
import java.sql.*;
import java.util.Timer;
import java.util.TimerTask;

public class SendLocation extends ActionBarActivity implements
        GooglePlayServicesClient.ConnectionCallbacks,
        GooglePlayServicesClient.OnConnectionFailedListener,
        LocationListener {

    private final static int CONNECTION_FAILURE_RESOLUTION_REQUEST = 9000;
    private TextView TV_status;
    private EditText ET_myBusID, ET_IP, ET_port;
    private Button BTN_save;
    private LocationClient mLocationClient;
    private Location mCurrentLocation;
    private LocationRequest mLocationRequest;
    private static final int UPDATE_INTERVAL = 15000; //ms
    private boolean mUpdatesRequested;
    private SharedPreferences mPrefs;
    private SharedPreferences.Editor mEditor;
    private Random randomGenerator = new Random();
    private int myBusID = randomGenerator.nextInt(1000);
    private String server; // = "10.109.53.17";
    private int port;// = 12345;
    private Timer t;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_send_location);
        TV_status = (TextView) findViewById(R.id.TV_status);
        TV_status.setText("BUS TRACKER");

        mUpdatesRequested = true;

        ET_myBusID = (EditText) findViewById(R.id.ET_busid);
        ET_IP = (EditText) findViewById(R.id.ET_ip);
        ET_port = (EditText) findViewById(R.id.ET_port);
        BTN_save = (Button) findViewById(R.id.BTN_save);
        BTN_save.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                myBusID = Integer.parseInt(ET_myBusID.getText().toString());
                server = ET_IP.getText().toString();
                port = Integer.parseInt(ET_port.getText().toString());
                BTN_save.setEnabled(false);

                t = new Timer();
                t.scheduleAtFixedRate(new TimerTask() {
                    @Override
                    public void run() {
                        Log.d("TimerTask", "Sending Location ...");
                        new SendLocnAsyncTask().execute();
                    }
                }, 1000, UPDATE_INTERVAL);

                Log.d("BTN_save", "config info saved");
                ET_IP.setEnabled(false);
                ET_port.setEnabled(false);
                ET_myBusID.setEnabled(false);

            }
        });

        // Open the shared preferences
        mPrefs = getSharedPreferences("SharedPreferences",
                Context.MODE_PRIVATE);
        // Get a SharedPreferences editor
        mEditor = mPrefs.edit();

         /*
         * Create a new location client, using the enclosing class to
         * handle callbacks.
         */
        mLocationClient = new LocationClient(this, this, this);
        // Create the LocationRequest object
        mLocationRequest = LocationRequest.create();
        // Use high accuracy
        mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);

        mLocationRequest.setInterval(UPDATE_INTERVAL);
    }

    /*
     * Called when the Activity becomes visible.
     */
    @Override
    protected void onStart() {
        super.onStart();
        // Connect the client.
        mLocationClient.connect();
    }

    @Override
    protected void onPause() {
        // Save the current setting for updates
        mEditor.putBoolean("KEY_UPDATES_ON", mUpdatesRequested);
        mEditor.commit();
        super.onPause();
    }

    /*
     * Called when the Activity is no longer visible.
     */
    @Override
    protected void onStop() {
        // If the client is connected
        if (mLocationClient.isConnected()) {
            /*
             * Remove location updates for a listener.
             * The current Activity is the listener, so
             * the argument is "this".
             */
            mLocationClient.removeLocationUpdates(this);
        }
        /*
         * After disconnect() is called, the client is
         * considered "dead".
         */
        mLocationClient.disconnect();
        t.cancel();
        super.onStop();
    }

    @Override
    protected void onResume() {
        super.onResume();
        /*
         * Get any previous setting for location updates
         * Gets "false" if an error occurs
         */
        if (mPrefs.contains("KEY_UPDATES_ON")) {
            mUpdatesRequested =
                    mPrefs.getBoolean("KEY_UPDATES_ON", false);

            // Otherwise, turn off location updates
        } else {
            mEditor.putBoolean("KEY_UPDATES_ON", false);
            mEditor.commit();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.send_location, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    /*
    * Called by Location Services when the request to connect the
    * client finishes successfully. At this point, you can
    * request the current location or start periodic updates
    */
    @Override
    public void onConnected(Bundle dataBundle) {
        // Display the connection status
        Toast.makeText(this, "Connected to location service", Toast.LENGTH_SHORT).show();
        // If already requested, start periodic updates
        if (mUpdatesRequested) {
            mLocationClient.requestLocationUpdates(mLocationRequest, this);
        }
    }

    /*
     * Called by Location Services if the connection to the
     * location client drops because of an error.
     */
    @Override
    public void onDisconnected() {
        // Display the connection status
        Toast.makeText(this, "Uh-oh. Disconnected. Please re-connect.",
                Toast.LENGTH_SHORT).show();
    }

    /*
     * Called by Location Services if the attempt to
     * Location Services fails.
     */
    @Override
    public void onConnectionFailed(ConnectionResult connectionResult) {
        /*
         * Google Play services can resolve some errors it detects.
         * If the error has a resolution, try sending an Intent to
         * start a Google Play services activity that can resolve
         * error.
         */
        if (connectionResult.hasResolution()) {
            try {
                // Start an Activity that tries to resolve the error
                connectionResult.startResolutionForResult(
                        this,
                        CONNECTION_FAILURE_RESOLUTION_REQUEST);
                /*
                 * Thrown if Google Play services canceled the original
                 * PendingIntent
                 */
            } catch (IntentSender.SendIntentException e) {
                // Log the error
                e.printStackTrace();
            }
        } else {
            /*
             * If no resolution is available, display a dialog to the
             * user with the error.
             */
            Toast.makeText(this, connectionResult.getErrorCode(),
                    Toast.LENGTH_SHORT).show();
        }
    }

    // Define a DialogFragment that displays the error dialog
    public static class ErrorDialogFragment extends DialogFragment {
        // Global field to contain the error dialog
        private Dialog mDialog;
        // Default constructor. Sets the dialog field to null
        public ErrorDialogFragment() {
            super();
            mDialog = null;
        }
        // Set the dialog to display
        public void setDialog(Dialog dialog) {
            mDialog = dialog;
        }
        // Return a Dialog to the DialogFragment.
        @Override
        public Dialog onCreateDialog(Bundle savedInstanceState) {
            return mDialog;
        }
    }
    /*
     * Handle results returned to the FragmentActivity
     * by Google Play services
     */
    @Override
    protected void onActivityResult(
            int requestCode, int resultCode, Intent data) {
        // Decide what to do based on the original request code
        switch (requestCode) {
            case CONNECTION_FAILURE_RESOLUTION_REQUEST :
            /*
             * If the result code is Activity.RESULT_OK, try
             * to connect again
             */
                switch (resultCode) {
                    case Activity.RESULT_OK :
                    /*
                     * Try the request again
                     */
                        break;
                }

        }
    }

    private boolean servicesConnected() {
        // Check that Google Play services is available
        int resultCode =
                GooglePlayServicesUtil.
                        isGooglePlayServicesAvailable(this);
        // If Google Play services is available
        if (ConnectionResult.SUCCESS == resultCode) {
            // In debug mode, log the status
            Log.d("Location Updates",
                    "Google Play services is available.");
            // Continue
            return true;
            // Google Play services was not available for some reason
        } else {
            Log.d("Location Updates",
                    "Google Play services is NOT available.");
        }
        return false;
    }

    // Define the callback method that receives location updates
    @Override
    public void onLocationChanged(Location location) {
        // Report to the UI that the location was updated
        String msg = "Updated Location: " +
                Double.toString(location.getLatitude()) + "," +
                Double.toString(location.getLongitude());
        Toast.makeText(this, msg, Toast.LENGTH_LONG).show();
        mCurrentLocation = location;
        Geocoder geocoder = new Geocoder(this, Locale.getDefault());
        String results=null;
        try{
            List<Address> addresses = geocoder.getFromLocation(mCurrentLocation.getLatitude(), mCurrentLocation.getLongitude(), 1);
            if (addresses != null && addresses.size() > 0) {
                Address address = addresses.get(0);
                // sending back first address line and locality
                results = address.getAddressLine(0) + ", " + address.getLocality();
            }
        }
        catch (IOException e)
        {
            Log.e("tag","Cannot Connect to Geocoder",e);
        }finally {
        TV_status.setText("Latitude  " + mCurrentLocation.getLatitude() + "\nLongitude " + mCurrentLocation.getLongitude() +"\n"+results);
        }
    }

    private void displayLocation(){

        mCurrentLocation = mLocationClient.getLastLocation();
        Geocoder geocoder = new Geocoder(this, Locale.getDefault());
        String results=null;
        try{
            List<Address> addresses = geocoder.getFromLocation(mCurrentLocation.getLatitude(), mCurrentLocation.getLongitude(), 1);
            if (addresses != null && addresses.size() > 0) {
                Address address = addresses.get(0);
                // sending back first address line and locality
                results = address.getAddressLine(0) + ", " + address.getLocality();
            }
        }
        catch (IOException e)
        {
            Log.e("tag","Cannot Connect to Geocoder",e);
        }finally {
        TV_status.setText("Latitude : " + mCurrentLocation.getLatitude() + ", Longitude : " + mCurrentLocation.getLongitude()
                +", Landmark : "+results);
        }
    }

    private String sendLocation(){
        Log.d("POSTLocation", "sending location ...");
        Geocoder geocoder = new Geocoder(this, Locale.getDefault());
        String results=null;
        String result = "";
        try{
            List<Address> addresses = geocoder.getFromLocation(mCurrentLocation.getLatitude(), mCurrentLocation.getLongitude(), 1);
            if (addresses != null && addresses.size() > 0) {
                Address address = addresses.get(0);
                // sending back first address line and locality
                results = address.getAddressLine(0) + ", " + address.getLocality();
            }
        }
        catch (IOException e)
        {
            Log.e("tag","Cannot Connect to Geocoder",e);
        }finally {


        Log.d("POSTLocation", "trying to send location");
        if(!isConnected())
        {
            return "you are not connected to the network!";
        }

            try {
                String json;

                JSONObject jsonObject = new JSONObject();
                jsonObject.accumulate("type", "bus-data");
                jsonObject.accumulate("bus-id", myBusID);
                jsonObject.accumulate("bus-longitude", mCurrentLocation.getLongitude());
                jsonObject.accumulate("bus-latitude", mCurrentLocation.getLatitude());
                jsonObject.accumulate("landmark",results);

                json = jsonObject.toString();
                Log.d("POSTLocation", "JSON : " + json);

                Socket socket = new Socket(server, port);
                OutputStream out = socket.getOutputStream();
                PrintWriter output = new PrintWriter(out);
                output.println(json);
                output.flush();
                output.close();
                socket.close();

            } catch (Exception e) {
                Log.d("InputStream", e.getLocalizedMessage());
            }

        }
        return result;
    }

    public boolean isConnected(){
        ConnectivityManager connMgr = (ConnectivityManager) getSystemService(Activity.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnected())
            return true;
        else
            return false;
    }

    private class SendLocnAsyncTask extends AsyncTask<String, Void, String> {
        @Override

        protected String doInBackground(String... str) {
            return sendLocation();
        }
        // onPostExecute displays the results of the AsyncTask.
        @Override
        protected void onPostExecute(String result) {
            //Toast.makeText(getBaseContext(), "done executing post locn. result : " + result, Toast.LENGTH_LONG).show();
        }
    }

    private static String convertInputStreamToString(InputStream inputStream) throws IOException {
        BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(inputStream));
        String line = "";
        String result = "";
        while((line = bufferedReader.readLine()) != null)
            result += line;

        inputStream.close();
        return result;

    }
}
