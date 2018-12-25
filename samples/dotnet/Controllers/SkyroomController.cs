using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json;
using Newtonsoft.Json.Serialization;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Headers;

namespace Skyroom.Client.Controllers
{
    [Route("/")]
    [ApiController]
    public class SkyroomController : ControllerBase
    {
        // HttpClient singleton
        public static readonly HttpClient HttpClient = new HttpClient();

        public class PostData
        {
            public string APIUrl { get; set; }
            public string Action { get; set; }
        }

        /// <summary>
        /// Calls API for specific action
        /// </summary>
        /// <param name="data">Request params</param>
        /// <returns>Formatted response from API or error if API call failed</returns>
        [HttpPost]
        public IActionResult Post(PostData data)
        {
            // Make sure apiKey and action is provided
            if (data.APIUrl.Length == 0 || data.Action.Length == 0)
            {
                return Content("Invalid request");
            }

            // Initiate params object
            var paramz = new Dictionary<string, object>();

            // Set default params based on action
            switch (data.Action)
            {
                case "getRoom":
                    paramz.Add("room_id", 1175);
                    break;

                case "getRoomUrl":
                    paramz.Add("room_id", 1175);
                    paramz.Add("relative", true);
                    break;

                case "createRoom":
                    {
                        long ts = (DateTime.UtcNow.Ticks - new DateTime(1970, 1, 1).Ticks) / TimeSpan.TicksPerSecond;
                        paramz.Add("name", "room-" + ts);
                        paramz.Add("title", "Room " + (new Random().Next()));
                        paramz.Add("max_users", (new Random().Next(2, 50)));
                        paramz.Add("guest_login", true);
                    }
                    break;

                case "updateRoom":
                    paramz.Add("room_id", 1178);
                    break;

                case "deleteRoom":
                    paramz.Add("room_id", 1177);
                    break;

                case "getRoomUsers":
                    paramz.Add("room_id", 1175);
                    break;

                case "addRoomUsers":
                    paramz.Add("room_id", 1175);
                    paramz.Add("users", new List<Dictionary<string, int>>()
                    {
                        new Dictionary<string, int>
                        {
                            {"user_id", 6344 },
                        },
                        new Dictionary<string, int>
                        {
                            {"user_id", 6345 },
                            {"access", Skyroom.USER_ACCESS_PRESENTER }
                        }
                    });
                    break;

                case "removeRoomUsers":
                    paramz.Add("room_id", 1175);
                    paramz.Add("users", new List<int> { 6344, 6345 });
                    break;

                case "updateRoomUser":
                    paramz.Add("room_id", 1145);
                    paramz.Add("user_id", 6344);
                    paramz.Add("access", Skyroom.USER_ACCESS_OPERATOR);
                    break;

                case "getUser":
                    paramz.Add("user_id", 6361);
                    break;

                case "createUser":
                    {
                        long ts = (DateTime.UtcNow.Ticks - new DateTime(1970, 1, 1).Ticks) / TimeSpan.TicksPerSecond;
                        paramz.Add("username", "user-" + ts);
                        paramz.Add("nickname", "User " + (new Random().Next(1, 100)));
                        paramz.Add("password", new Random().Next(8, 10));
                        paramz.Add("email", "test@gmail.com");
                        paramz.Add("fname", "First Name");
                        paramz.Add("lname", "Last Name");
                        paramz.Add("is_public", true);
                    }
                    break;

                case "updateUser":
                    paramz.Add("user_id", 6361);
                    break;

                case "deleteUser":
                    paramz.Add("user_id", 6346);
                    break;

                case "getUserRooms":
                    paramz.Add("user_id", 6347);
                    break;

                case "addUserRooms":
                    paramz.Add("user_id", 6347);
                    paramz.Add("rooms", new List<Dictionary<string, int>>
                    {
                        new Dictionary<string, int>
                        {
                            { "room_id", 1175 }
                        },
                        new Dictionary<string, int>
                        {
                            { "room_id", 1175 },
                            { "access", Skyroom.USER_ACCESS_PRESENTER}
                        }
                    });
                    break;

                case "removeUserRooms":
                    paramz.Add("user_id", 6347);
                    paramz.Add("rooms", new List<int> { 1175, 1179 });
                    break;

                case "getLoginUrl":
                    paramz.Add("room_id", 1174);
                    paramz.Add("user_id", 6347);
                    paramz.Add("ttl", 60);
                    break;
            }

            // Call api and get result
            HttpResponseMessage response;
            try
            {
                response = HttpClient.PostAsJsonAsync<Dictionary<String, object>>(
                    data.APIUrl,
                    new Dictionary<String, object>
                    {
                        { "action", data.Action },
                        { "params", paramz }
                    }
                )
                .Result;

                // Check the result
                if (response.IsSuccessStatusCode)
                {
                    // Read result from stream
                    string res = response.Content.ReadAsStringAsync().Result;

                    // Deserialize result
                    var resultDictionary = JsonConvert.DeserializeObject<Dictionary<string, object>>(res);

                    // Send json to client
                    return new JsonResult(resultDictionary);
                }
                else
                {
                    // Return error indicator
                    return Content("Internal Server Error");
                }
            }
            catch(AggregateException)
            {
                return Content("Network Error");
            }
            catch(JsonReaderException)
            {
                // Should never occur
                return Content("Invalid Response");
            }
        }
    }
}
