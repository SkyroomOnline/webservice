using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Skyroom.Client
{
    public class Skyroom
    {
        public static readonly string VERSION = "1.1";

        public static readonly int ROOM_STATUS_DISABLED   = 0;
        public static readonly int ROOM_STATUS_ENABLED    = 1;

        public static readonly int USER_STATUS_DISABLED   = 0;
        public static readonly int USER_STATUS_ENABLED    = 1;

        public static readonly int USER_GENDER_UNKNOWN    = 0;
        public static readonly int USER_GENDER_MALE       = 1;
        public static readonly int USER_GENDER_FEMALE     = 2;

        public static readonly int USER_ACCESS_NORMAL     = 1;
        public static readonly int USER_ACCESS_PRESENTER  = 2;
        public static readonly int USER_ACCESS_OPERATOR   = 3;
        public static readonly int USER_ACCESS_ADMIN      = 4;
    }
}
